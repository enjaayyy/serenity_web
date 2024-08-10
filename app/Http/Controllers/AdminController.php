<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class AdminController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function viewRequests()
    {
        $view = $this->database->getReference('administrator/doctorRequests/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = [];

        if ($data) {
            foreach ($data as $id => $doctor) {
                $details[] = [
                    'id' => $id,
                    'name' => $doctor['doctorFullname'],
                    'email' => $doctor['doctorEmail'],
                    'profession' => $doctor['profession'],
                    'specialization' => $doctor['specialization'],
                ];

          
            }
        }
        return view('administrator.adminReqeusts', ['details' => $details]);    
    }

    public function viewRequestDetails($id){
        $view = $this->database->getReference('administrator/doctorRequests/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        if($data){
            $details = [
                'id' => $id,
                'name' => $data['doctorFullname'],
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
            return view('administrator.adminRequestDetails', ['details' => $details]);
        }

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

            if($new['specialization'] == 'Anxiety'){
                $questions = [
                    'Q1' => 'Worries, Anticipation of the worst, Fearful, Irritability.',
                    'Q2' => 'Feelings of tension, Fatigability, startle response, moved to tears easily, trembling, feelings of restlessness, inability to relax.',
                    'Q3' => 'Fear of dark, of strangers, of being left alone, of animals, of traffic, of crowds.',
                    'Q4' => 'Difficulty in falling asleep, broken sleep, unsatisfying sleep and fatigue on waking, dreams, nightmares, night terrors.',
                    'Q5' => 'Difficulty in concentration, poor memory. ',
                    'Q6' => 'Loss of interest, lack of pleasure in hobbies, depression, early waking.',
                    'Q7' => 'Pains and aches, twitching, stiffness, jerks, grinding of teeth, unsteady voice, increased muscular tone.',
                    'Q8' => 'Blurring of vision, hot and cold flushes, feelings of weakness, pricking sensation.',
                    'Q9' => 'Palpiations, pain in chest, throbbing of vessels,fainting feelings, missing beat.',
                    'Q10' => 'Constriction in chest, choking feelings, sighing.',
                    'Q11' => 'Difficulty in swallowing, wind abdominal pain, burning sensations, nausea, abdominal fullness, vomitting, constipation.',
                    'Q12' => 'Impotence, Loss of libido, premature ejaculation,',
                    'Q13' => 'Dry mouth, tendency to sweat, headache, raising of hair, giddiness.'

                ];
                $this->database->getReference('administrator/doctors' . "/" . $id . "/questionnaires")->push($questions);
            }
            else if($new['specialization'] == 'Insomnia'){
                 $questions = [
                    'Q1' => 'How long does it take you to fall asleep?',
                    'Q2' => 'if you wake up during the night how long are you awake for in total?',
                    'Q3' => 'How many nights a week do you have a problem with your sleep?',
                    'Q4' => 'How would you rate your sleep quality?',
                    'Q5' => 'Affected your mood, energy or relationships?',
                    'Q6' => 'Affected you concentration, productivity, or ability to stay awake.',
                    'Q7' => 'Troubled you in general.',
                    'Q8' => 'How long have you had a problem with your sleep?',

                ];
                $this->database->getReference('administrator/doctors' . "/" . $id . "/questionnaires")->push($questions);
            }
            else if($new['specialization'] == 'Post Traumatic Stress'){
                $questions = [
                    //IES-R standard questionnaire
                    'Q1' => 'Any reminder brought back feelings about it',
                    'Q2' => 'I had trouble staying asleep',
                    'Q3' => 'Other things kept making me think about it',
                    'Q4' => 'I felt irritable and angry',
                    'Q5' => 'I avoided letting myself get upset when I thought about it or was reminded of it',
                    'Q6' => 'I thought about it when I didnt mean to',
                    'Q7' => 'I felt as if it ha dnot happened ow was not real',
                    'Q8' => 'I stayed away from reminders of it.',
                    'Q9' => 'Pictures about it popped into my mind',
                    'Q10' => 'I was jumpy and easily startled',
                    'Q11' => 'I tried not to think about it',
                    'Q12' => 'I was aware that I still had a lot of feelings about it, but I did not deal with them',
                    'Q13' => 'My feelings about it were kind of numb',
                    'Q14' => 'I found myself acting or feeling like I was back at that time',
                    'Q15' => 'I had trouble falling asleep',
                    'Q16' => 'I had waves of strong feelings about it',
                    'Q17' => 'I tring to remove it from my memory',
                    'Q18' => 'I had trouble concentrating',
                    'Q19' => 'Reminders of it caused me to have physical reactions, such as sweating, trouble breathing, nausea, or a pounding heart.',
                    'Q20' => 'I had dreams about it',
                    'Q21' => 'I felt watchful and on-guard',
                    'Q22' => 'I tried not to talk about it',
                ];
                $this->database->getReference('administrator/doctors' . "/" . $id . "/questionnaires")->push($questions);
            }
             return redirect()->route('adminRequests');
        
        }
    }

    public function viewDocList(){

        $view = $this->database->getReference('administrator/doctors/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = []; 

        if($data){
            foreach($data as $id => $doctor) {
                $details[] = [
                    'id' => $id,
                    'docname' => $doctor['name'],
                    'docemail' => $doctor['email'],
                    'docprofession' => $doctor['profession'],
                    'docspecialization' => $doctor['specialization'],
                ];
            }
           
        }
         return view('administrator.doctors', ['details' => $details]);
    }

    public function viewdoctor($id){
        $view = $this->database->getReference("administrator/doctors/" . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $questions = $this->database->getReference("administrator/doctors/" . $id . "/questionnaires");
        $get = $questions->getSnapshot();
        $questiondata = $get->getValue();

        if($data) {
            $details = [
                'id' => $id,
                'name' => $data['name'],
                'age' => $data['age'],
                'email' => $data['email'],
                'gender' =>$data['gender'],
                'license' =>$data['license'],
                'profession' =>$data['profession'],
                'specialization' => $data['specialization'],
                'address' => $data['address'],
                'years' => $data['years'],
                'credentials' => $data['credentials'],
                'questionnaires' => $questiondata ? $questiondata : []
            ];
        }
        return view("administrator.doctorProfile", ['details' => $details]);

    }

    public function deactivate($id){
        $view = $this->database->getReference('administrator/doctors/' . $id);
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $this->database->getReference('administrator/archives/' . $id)->set($data);
        $this->database->getReference('administrator/doctors/' . $id)->remove();
    
        return redirect()->route('doctors');
    }

    public function viewArchive(){
        $view = $this->database->getReference('administrator/archives/');
        $snapshot = $view->getSnapshot();
        $data = $snapshot->getValue();

        $details = [];
        
            if($data){
            foreach($data as $id => $doctor){
                $details[] = [
                    'id' => $id,
                    'name' => $doctor['name'],
                    'email' => $doctor['email'],
                    'specialization' => $doctor['specialization'],
                    'profession' => $doctor['profession'],
                ];
            }
        
        }
        return view("administrator.arhive", ['details' => $details]);
    }

    public function activate($id){
        $archRef = $this->database->getReference('administrator/archives/' . $id);
        $archData = $archRef->getValue();

        if($archData){
            $this->database->getReference('administrator/doctors/' . $id)->set($archData);
            $archRef->remove();
        }

        return redirect()->route('doctors');
    }

    
}
 