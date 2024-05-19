<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    public $filters = [];
    public $sort = 'default';
    protected $filter_options;
    protected $sort_values;
    protected $sort_options;
    public $selected;
    public $search_query;

    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public function updating($name,$value) {
        if (substr($name,0,7)=='filters' || $name=='sort' || $name="search_query") {
            $this->resetPage();
        }
    }

    protected function addFilters($query) {
        if (!$this->filter_options) return false;

        $filtering = false;

        // Apply the default filters
        foreach($this->filter_options as $key => $filter) {
            if (isset($this->filters[$key])) continue;
            if (isset($filter['default'])) {
                $this->filters[$key] = $filter['default'];
            }
        }
        foreach($this->filters as $key => $value) {
            if (!isset($this->filter_options[$key]['field'])) continue;
            if ($value != 'default') {
                if (isset($this->filter_options[$key]['default']) && $this->filter_options[$key]['default'] != $value) {
                    $filtering = true;
                } else {
                    if ($value != "" && $value != null) {
                        $filtering = true;
                    }
                }

                $filter = $this->filter_options[$key];
                if (isset($filter['type']) && ($filter['type']=='autocomplete')) {
                    if ($value!="") {
                        $query->where($filter['field'],$value);
                    }
                }  else if (isset($filter['type']) && ($filter['type']=='text')) {
                    if ($value!="") {
                        $query->where($filter['field'],'like', '%'.$value.'%');
                    }
                } else {
                    if (is_array($filter['filters'][$value])) {
                        if ($filter['filters'][$value]['type']=='in') {
                            $query->whereIn($filter['field'],$filter['filters'][$value]['values']);
                        } else {
                            $query->where($filter['field'],$filter['filters'][$value]['type'],$filter['filters'][$value]['value']);
                        }
                    } else {
                        $query->where($filter['field'],$filter['filters'][$value]);
                    }    
                }
            }
        }

        return $filtering;
    }

    protected function addOrderBy($query) {
        if ($this->sort != 'default') {
            $query->orderBy($this->sort_values[$this->sort]['field'],$this->sort_values[$this->sort]['direction']);
        }
    }

    protected function getSelected($class) {
        $selected = [];
        foreach($this->selected as $id => $val) {
            if ($val) {
                $selected[] = $class::findOrFail($id);
            }
        }
        return $selected;
    }

    public function set_filter($name,$value) {
        $this->filters[$name] = $value;
    }

}
