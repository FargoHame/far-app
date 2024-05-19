<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Specialty;
use App\Models\FileType;

class HardcodedData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileType::query()->delete();
        Specialty::query()->delete();

        $fileTypes = [
            'Cover Letter',
            'Drug Screen',
            'Background Check',
            'Vaccination Records',
            'Liability Insurance',
            'Health Insurance',
            'Letter of Good Standing',
            'School Transcripts',
            'Government Identification',
            'First Exam Score',
            'Second Exam Score',
            'Clinical Exam Score',
            'BLS Certificate',
            'PALS Certificate',
            'ALS Certificate',
            'HIPAA Certificate',
            'OSHA Certificate',
            'ECFMG Certificate',
        ];
        foreach($fileTypes as $type) {
            $f = new FileType();
            $f->name = $type;
            $f->save();
        }

        $specialties = [
            'Allergy and Immunology',
            'Anatomic and Clinical Pathology',
            'Anesthesiology & Pain Medicine',
            'Cardiology',
            'Dermatology',
            'Diagnostic Radiology',
            'Emergency Medicine',
            'Endocrinology',
            'Family Medicine',
            'Gastroenterology',
            'Geriatrics (Internal Medicine)',
            'Geriatric Medicine (Family Medicine)',
            'Hematology/Oncology',
            'Hepatology',
            'Infectious Disease',
            'Internal Medicine (General)',
            'Medical Genetics and Genomics',
            'Neurology',
            'Nuclear Medicine',
            'Obstetrics and Gynecology',
            'Ophthalmology',
            'Osteopathic Neuromusculoskeletal Medicine',
            'Otolaryngology',
            'Pediatrics',
            'Physical Medicine and Rehabilitation',
            'Plastic Surgery',
            'Pulmonology/Critical Care',
            'Preventive Medicine',
            'Psychiatry',
            'Radiation Oncology',
            'Rheumatology',
            'Sleep Medicine',
            'Sports Medicine',
            'Surgery - General',
            'Surgery - Subspecialty',
            'Urology'
        ];
        foreach($specialties as $specialty) {
            $s = new Specialty();
            $s->name = $specialty;
            $s->save();
        }

    }
}
