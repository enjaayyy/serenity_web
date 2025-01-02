<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Contract\Storage;

class QuestionnaireController extends Controller
{
    public function __construct(Database $database, Storage $storage){
        $this->database = $database;
        $this->storage = $storage;
        $this->bucket = $this->storage->getBucket();
    }

    public function approve($id){
        $view = $this->database->getReference('administrator/doctorRequests/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $new = [
                'name' => $data['doctorFullname'],
                'pass' => $data['doctorPass'],
                'age' => $data['age'],
                'email' => $data['doctorEmail'],
                'gender' =>$data['gender'],
                'license' =>$data['medicalLicencse'],
                'profession' =>$data['profession'],
                'specialization' => $data['specialization'],
                'address' => $data['workAddress'],
                'years' => $data['yearsOfService'],
                'credentials' => $data['credentials'],
        ];


        $this->database->getReference('administrator/doctors' . "/" . $id)->set($new);
        $this->database->getReference('administrator/doctorRequests' . "/" . $id)->remove();

        $title = 'default';
        $questionnaires = [];


       foreach($data['specialization'] as $specData) {
        if(in_array($specData, $data['specialization'])) {
             $questions = $this->questionBySpecialization($specData, $title);
            if ($questions) {
                    $questionnaires[$specData] = $questions;
                }
            }   
            $this->database->getReference('administrator/doctors/' . $id . '/activeQuestionnaires')->update($questionnaires);
            $this->database->getReference('administrator/doctors/' . $id . '/savedQuestionnaires')->update($questionnaires);
        }
            
            

            return redirect()->route('adminRequests');
        }
    }

    private function questionBySpecialization($specialization, $title){
         $questions = [
            'Anxiety' => [
                'title' => $title,
                'Anxious Mood' => [
                    'Q1' => [
                        'question' => 'Worries, Anticipation of the worst, Fearful, Irritability.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                 'Tension' => [
                    'Q1' => [
                        'question' => 'Feelings of tension, Fatigability, startle response, moved to tears easily, trembling, feelings of restlessness, inability to relax.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                 'Fears' => [
                    'Q1' => [
                        'question' => 'Fear of dark, of strangers, of being left alone, of animals, of traffic, of crowds.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                 'Insomnia' => [
                    'Q1' => [
                        'question' => 'Difficulty in falling asleep, broken sleep, unsatisfying sleep and fatigue on waking, dreams, nightmares, night terrors.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                 'Intellectual' => [
                    'Q1' => [
                        'question' => 'Difficulty in concentration, poor memory. ',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Depressed Mood' => [
                    'Q1' => [
                        'question' => 'Loss of interest, lack of pleasure in hobbies, depression, early waking.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Somatic(Muscular)' => [
                    'Q1' => [
                        'question' => 'Pains and aches, twitching, stiffness, jerks, grinding of teeth, unsteady voice, increased muscular tone.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Somatic(Sensory)' => [
                    'Q1' => [
                        'question' => 'Blurring of vision, hot and cold flushes, feelings of weakness, pricking sensation.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Cardiovascular Symptoms' => [
                     'Q1' => [
                        'question' => 'Palpiations, pain in chest, throbbing of vessels,fainting feelings, missing beat.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Respiratory Symptoms' => [
                    'Q1' => [
                        'question' => 'Constriction in chest, choking feelings, sighing.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ], 
                'Gastrointestinal Symptoms' => [
                    'Q1' => [
                        'question' => 'Difficulty in swallowing, wind abdominal pain, burning sensations, nausea, abdominal fullness, vomitting, constipation.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Genitourinary Symptoms' => [
                    'Q1' => [
                        'question' => 'Impotence, Loss of libido, premature ejaculation,',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
                'Autonomic Symptoms' => [
                    'Q1' => [
                        'question' => 'Dry mouth, tendency to sweat, headache, raising of hair, giddiness.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],

            ],
            'Insomnia' => [
                'title' => $title,
                'Think about a typical night this week' => [
                    'Q1' => [
                        'question' => 'Dry mouth, tendency to sweat, headache, raising of hair, giddiness.',
                        'legend' => ['not at all', 'a little bit', 'moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q2' => [
                        'question' => 'if you wake up during the night how long are you awake for in total?',
                        'legend' => ['0-15 min', '16-30 min', '31-45 min', '46-60 min', '>61 min'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                    'Q3' => [
                        'question' => 'How many nights a week do you have a problem with your sleep?',
                        'legend' => ['1', '2', '3', '4', '5-7'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                    'Q4' => [
                        'question' => 'How would you rate your sleep quality?',
                        'legend' => ['Very good', 'Good', 'Average', 'Poor', 'Very Poor'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                ],
                'Thinking about this week, to what extent has poor sleep' => [
                    'Q1' => [
                        'question' => 'Affected your mood, energy or relationships?',
                        'legend' => ['Not at all', 'a little', 'Somewhat', 'Much', 'Very Much'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                    'Q2' => [
                        'question' => 'Affected you concentration, productivity, or ability to stay awake.',
                        'legend' => ['Not at all', 'a little', 'Somewhat', 'Much', 'Very Much'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                    'Q3' => [
                        'question' => 'Troubled you in general.',
                        'legend' => ['Not at all', 'a little', 'Somewhat', 'Much', 'Very Much'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                    'Q4' => [
                        'question' => 'How long have you had a problem with your sleep?',
                        'legend' => ['<1 month', '1-2 months', '3-6 months', '7-12 months', '> 1 year'],
                        'value' => ['4', '3', '2', '1', '0']
                    ],
                ],
            ],
            'Post Traumatic Stress' => [
                'title' => $title,
                'In the past month, how much were you bothered by:' => [
                    'Q1' => [
                        'question' => 'Any reminder brought back feelings about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q2' => [
                        'question' => 'I had trouble staying asleep',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q3' => [
                        'question' => 'Other things kept making me think about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q4' => [
                        'question' => 'I felt irritable and angry',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q5' => [
                        'question' => 'I avoided letting myself get upset when I thought about it or was reminded of it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q6' => [
                        'question' => 'I thought about it when I didnt mean to',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q7' => [
                        'question' => 'I felt as if it ha dnot happened ow was not real',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q8' => [
                        'question' => 'I stayed away from reminders of it.',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q9' => [
                        'question' => 'Pictures about it popped into my mind',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q10' => [
                        'question' => 'I was jumpy and easily startled',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q11' => [
                        'question' => 'I tried not to think about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q12' => [
                        'question' => 'I was aware that I still had a lot of feelings about it, but I did not deal with them',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q13' => [
                        'question' => 'My feelings about it were kind of numb',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q14' => [
                        'question' => 'I found myself acting or feeling like I was back at that time',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q15' => [
                        'question' => 'I had trouble falling asleep',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                    'Q16' => [
                        'question' => 'I had waves of strong feelings about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ], 
                    'Q17' => [
                        'question' => 'Im tring to remove it from my memory',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ], 
                    'Q18' => [
                        'question' => 'I had trouble concentrating',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ], 
                    'Q19' => [
                        'question' => 'Reminders of it caused me to have physical reactions, such as sweating, trouble breathing, nausea, or a pounding heart.',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],  
                    'Q20' => [
                        'question' => 'I had dreams about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ], 
                    'Q21' => [
                        'question' => 'I felt watchful and on-guard',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],  
                    'Q22' => [
                        'question' => 'I tried not to talk about it',
                        'legend' => ['Not at all', 'a little bit', 'Moderately', 'Quite a bit', 'Extremely'],
                        'value' => ['0', '1', '2', '3', '4']
                    ],
                ],
            ],
        ];
         
        return $questions[$specialization] ?? null;
    }
}
