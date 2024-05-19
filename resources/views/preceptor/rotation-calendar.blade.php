<x-app-layout>
  @section ('title', "Edit rotation")

  <div class="mx-auto w-full max-w-4xl px-4 pt-5">
    <div class="md:flex justify-between">
        <h1 class="text-2xl font-bold pb-3">Calendar</h1>
        <div class=" mb-4 flex justify-end">
            <a href="{{ url()->previous() }}" class="px-6 py-2 rounded-md btn-green text-white md:w-auto w-full text-center">Back</a>
        </div>
    </div>


      <form method="post" action="{{ route('preceptor-rotation-calendar-update') }}">
        @csrf
        <input type="hidden" value="{{ $rotation->id }}" name="id" />

        <table class="w-full mt-4">
          <tr class="font-bold">
            <td></td>
            <td></td>
            <td class="text-right pb-2"></td>
            <td class="text-center pb-2">Available?</td>
            <td class="text-center pb-2">Slots</td>
            <td class="text-center pb-2">Confirmed</td>
          </tr>
          @php
            $lastYear = '';
            $lastMonth = '';
          @endphp

          @foreach($weeks as $i => $week)
          @if(!\Carbon\Carbon::now()->addDays(7 * $i)->startOfWeek()->isPast())
            <input type="hidden" value="{{ $week['start']->toDateString() }}" name="week_{{ $i }}" />
            <tr>
              <td class="font-bold text-xl">{{ ($lastYear !=$week['start']->format('Y'))?$week['start']->format('Y'):'' }}</td>
              <td class="font-bold text-lg">{{ ($lastMonth!=$week['start']->format('M'))?$week['start']->format('M'):'' }}</td>
              <td class="text-right "><div class="gray-box font-bold">{{ $week['start']->format('M d') }} - {{ $week['start']->copy()->addDays(6)->format('M d') }}</div></td>
              <td class="text-center"><input type="checkbox" name="week_{{ $i }}_enabled" class="checkbox" {{ $week['enabled'] ? 'checked':'' }}  /></td>
              <td class="text-center"><x-input class="w-16 gray-font" id="week_{{ $i }}_slots" name="week_{{ $i }}_slots" type="number" min="{{ $week['enabled'] ? '1':'0' }} "  value="{{ $week['seats'] }}" style="border-radius: 6px;height: 30px;font-size: 12px;"/></td>
              <td class="text-center font-bold">{{ $week['confirmed'] }}</td>
            </tr>
            @php
              $lastYear = $week['start']->format('Y');
              $lastMonth = $week['start']->format('M');
            @endphp
          @endif
          @endforeach
        </table>

        <div class="my-3">
          <button type="submit" class="btn btn-green min-w-200" style="font-weight: normal">Update</button>
        </div>
      </form>
  </div>

  <div class="mx-auto md:hidden w-full px-4 pt-5 md:mt-6">
      <h1 class="text-3xl font-bold pb-3 border-b border-gray-600 border-dashed">Calendar</h1>
      <p class="mt-2">This screen is not available on mobile devices. Please use a desktop or tablet device.</p>
  </div>

  @push('scripts')
  <script>
    $(document).ready(function() {
      $(".enable_checkbox").change(function() {
        var name = $(this).attr('name');
        var slots = '#' + name.replace('_enabled','_slots');
        if ($(this).prop('checked')) {
          $(slots).attr('min','1');
        } else {
          $(slots).attr('min','0');
        }
        console.log($(slots).attr('min'));
      });
    });
  </script>
  @endpush
</x-app-layout>
