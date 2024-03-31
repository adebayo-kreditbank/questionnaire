<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    private static array $questions = [
        "Yes",
        "No",
        "Viagra or Sildenafil",
        "Cialis or Tadalafil",
        "Both",
        "None of the above",
        "Significant liver problems (such as cirrhosis of the liver) or kidney problems)",
        "Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment",
        "Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)",
        "Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin",
        "I don't have any of these conditions",
        "Alpha-blocker medication such as Alfuzosin, Doxazosin, Tamsulosin, Prazosin, Terazosin or over-the-counter Flomax",
        "Riociguat or other guanylate cyclase stimulators (for lung problems)",
        "Saquinavir, Ritonavir or Indinavir (for HIV)",
        "Cimetidine (for heartburn)",
        "I don't take any of these drugs"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Answer::count() > 0) return;

        foreach(static::$questions as $question) {
            Answer::factory()->create(['answer' => $question]);
        }
    }
}
