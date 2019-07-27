<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Guardian;
use App\Teacher;
use App\Student;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'name' => 'admin',
//            'email' => 'admin@schoolah.com',
//            'password' => bcrypt('admin'),
//            'role' => 'admin',
//            'phone_number' => '08123112211',
//            'is_change_password' => true,
//            'school_id' => null,
//            'address' => 'admin'
//        ]);
        $index = 1;

        $firstname = [
            "Abigail", "Alexandra", "Alison", "Amanda", "Amelia", "Amy", "Andrea", "Angela", "Anna",
            "Anne", "Audrey", "Ava", "Bella", "Bernadette", "Carol", "Caroline", "Carolyn", "Chloe",
            "Claire", "Deirdre", "Diana", "Diane", "Donna", "Dorothy", "Elizabeth", "Ella", "Emily",
            "Emma", "Faith", "Felicity", "Fiona", "Gabrielle", "Grace", "Hannah", "Heather", "Irene",
            "Jan", "Jane", "Jasmine", "Jennifer", "Jessica", "Joan", "Joanne", "Julia", "Karen",
            "Katherine", "Kimberly", "Kylie", "Lauren", "Leah", "Lillian", "Lily", "Lisa", "Madeleine",
            "Maria", "Mary", "Megan", "Melanie", "Michelle", "Molly", "Natalie", "Nicola", "Olivia",
            "Penelope", "Pippa", "Rachel", "Rebecca", "Rose", "Ruth", "Sally", "Samantha", "Sarah",
            "Sonia", "Sophie", "Stephanie", "Sue", "Theresa", "Tracey", "Una", "Vanessa", "Victoria",
            "Virginia", "Wanda", "Wendy", "Yvonne", "Zoe", "Adam", "Adrian", "Alan", "Alexander",
            "Andrew", "Anthony", "Austin", "Benjamin", "Blake", "Boris", "Brandon", "Brian", "Cameron",
            "Carl", "Charles", "Christian", "Christopher", "Colin", "Connor", "Dan", "David", "Dominic",
            "Dylan", "Edward", "Eric", "Evan", "Frank", "Gavin", "Gordon", "Harry", "Ian", "Isaac", "Jack",
            "Jacob", "Jake", "James", "Jason", "Joe", "John", "Jonathan", "Joseph", "Joshua", "Julian",
            "Justin", "Keith", "Kevin", "Leonard", "Liam", "Lucas", "Luke", "Matt", "Max", "Michael",
            "Nathan", "Neil", "Nicholas", "Oliver", "Owen", "Paul", "Peter", "Phil", "Piers", "Richard",
            "Robert", "Ryan", "Sam", "Sean", "Sebastian", "Simon", "Stephen", "Steven", "Stewart", "Thomas",
            "Tim", "Trevor", "Victor", "Warren", "William"
        ];

        $lastname = [
            "Abraham", "Allan", "Alsop", "Anderson", "Arnold", "Avery", "Bailey", "Baker", "Ball", "Bell",
            "Berry", "Black", "Blake", "Bond", "Bower", "Brown", "Buckland", "Burgess", "Butler", "Cameron",
            "Campbell", "Carr", "Chapman", "Churchill", "Clark", "Clarkson", "Coleman", "Cornish", "Davidson",
            "Davies", "Dickens", "Dowd", "Duncan", "Dyer", "Edmunds", "Ellison", "Ferguson", "Fisher",
            "Forsyth", "Fraser", "Gibson", "Gill", "Glover", "Graham", "Grant", "Gray", "Greene", "Hamilton",
            "Hardacre", "Harris", "Hart", "Hemmings", "Henderson", "Hill", "Hodges", "Howard", "Hudson",
            "Hughes", "Hunter", "Ince", "Jackson", "James", "Johnston", "Jones", "Kelly", "Kerr", "King",
            "Knox", "Lambert", "Langdon", "Lawrence", "Lee", "Lewis", "Lyman", "MacDonald", "Mackay",
            "Mackenzie", "MacLeod", "Manning", "Marshall", "Martin", "Mathis", "May", "McDonald", "McLean",
            "McGrath", "Metcalfe", "Miller", "Mills", "Mitchell", "Morgan", "Morrison", "Murray", "Nash",
            "Newman", "Nolan", "North", "Ogden", "Oliver", "Paige", "Parr", "Parsons", "Paterson", "Payne",
            "Peake", "Peters", "Piper", "Poole", "Powell", "Pullman", "Quinn", "Rampling", "Randall", "Rees",
            "Reid", "Roberts", "Robertson", "Ross", "Russell", "Rutherford", "Sanderson", "Scott", "Sharp",
            "Short", "Simpson", "Skinner", "Slater", "Smith", "Springer", "Stewart", "Sutherland", "Taylor",
            "Terry", "Thomson", "Tucker", "Turner", "Underwood", "Vance", "Vaughan", "Walker", "Wallace",
            "Walsh", "Watson", "Welch", "White", "Wilkins", "Wilson", "Wright", "Young"
        ];

        $phoneNumber = [
            "089655546021", "081855555721", "083855550921", "085755574321", "087855506321",
            "087855577921", "083855555521", "087855581221", "081755591821", "081755501521",
            "085255587521", "083855537921", "089955582921", "087855559321", "083855561021",
            "089655583721", "087855500921", "085555516521", "081655567121", "087855572921",
            "085855552921", "083855572421", "089655529221", "087855586821", "089755560021",
            "083855560821", "085755549521", "087855507021", "081955564421", "085955578421",
            "085355533421", "087855577721", "089655508021", "087855598821", "081855520221",
            "083855529621", "081755531321", "087855500421", "081755588221", "083855560821",
            "087855530921", "081355509521", "087855530021", "085855507221", "081655594821",
            "089855597521", "083855516721", "083855577221", "087855561921", "085655565821",
            "083855507621", "085855558721", "089655594321", "087855523221", "089655508321",
            "089955564721", "083855520921", "085855508521", "081555521621", "087855500621",
            "085955586221", "083855591121", "085555579521", "085655561521", "083855574421",
            "087855534221", "081855526021", "089855590121", "085755567421", "087855599621",
            "089955588821", "087855568021", "081755543721", "083855534521", "081855532721",
            "089755579821", "085455557721", "085555515321", "087855540121", "089755520621",
            "081955586921", "081255571221", "085255556621", "085955520421", "083855577721",
            "081755591121", "089955502921", "089855560121", "085755594921", "081255553221",
            "087855547321", "083855535321", "081355591521", "081755556921", "083855544121",
            "083855598221", "083855534321", "089655594221", "081855543621", "081855595821",
            "089955515521", "081355572121", "081155563621", "089855567521", "089855575521",
            "087855545921", "081355573021", "087855571821", "083855598521", "087855533321",
            "083855581921", "085955538621", "089755543021", "087855555121", "087855526421",
            "083855589021", "087855570421", "087855532921", "085355534821", "081255545221",
            "089655552721", "083855531721", "081455549421", "087855505421", "085855543221",
            "085555591021", "081355573721", "083855516021", "085455593821", "083855518421",
            "085655539121", "087855597721", "081955569721", "083855538321", "085255516721",
            "081355512521", "085955591321", "087855508621", "087855597321", "081855544721",
            "085355558721", "087855571821", "081555543521", "087855569921", "081155578321",
            "089655550721", "087855519921", "089755569721", "087855564421", "083855559721",
            "085655597921", "083855570421", "089755566621", "087855533021", "083855547021",
            "087855569421", "085455508921", "081255565421", "089755516721", "087855569821",
            "083855591221", "087855538921", "087855559721", "083855576621", "083855508321",
            "085655549521", "089855574621", "087855579721", "087855586921", "087855596221",
            "081555519321", "083855584421", "085255527821", "085455576821", "085355516021",
            "083855510721", "083855538821", "089655592021", "083855531921", "081655565721",
            "087855579121", "089955532321", "089855524121", "083855520721", "081955507621",
            "085555525721", "081455531621", "085655544921", "083855589821", "085855587521",
            "087855577721", "089755511021", "081355535521", "083855590421", "083855506421",
            "083855504121", "089755529521", "085355530021", "083855549821", "085555576921"
        ];

        for($i = 0; $i < 25; $i++) {
            $firstnameIndex = array_rand($firstname);
            $lastnameIndex = array_rand($lastname);
            $phoneNumberIndex = array_rand($phoneNumber);
            $name = $firstname[$firstnameIndex] . " " . $lastname[$lastnameIndex];
            $email = strtolower($firstname[$firstnameIndex].$lastname[$lastnameIndex])."@schoolah.com";

            $guardianUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('schoolah'),
                'role' => 'guardian',
                'phone_number' => $phoneNumber[$phoneNumberIndex],
                'is_change_password' => false,
                'school_id' => 1,
                'address' => '-'
            ]);

            $guardian = Guardian::create([
                'user_id' => $guardianUser->id
            ]);

            $firstnameStudentIndex = array_rand($firstname);
            $lastnameStudentIndex = array_rand($lastname);
            $phoneNumberStudentIndex = array_rand($phoneNumber);
            $nameStudent = $firstname[$firstnameStudentIndex] . " " . $lastname[$lastnameStudentIndex];
            $emailStudent = strtolower($firstname[$firstnameStudentIndex].$lastname[$lastnameStudentIndex])."@schoolah.com";

            if($index < 10)
                $code = "0".$index;
            else
                $code = $index;

            $studentUser = User::create([
                'name' => $nameStudent,
                'email' => $emailStudent,
                'password' => bcrypt('schoolah'),
                'role' => 'student',
                'phone_number' => $phoneNumber[$phoneNumberStudentIndex],
                'is_change_password' => false,
                'school_id' => 1,
                'address' => '-'
            ]);

            Student::create([
                'user_id' => $studentUser->id,
                'student_code' => "STDSUTOMO".$code,
                'guardian_id' => $guardian->id,
                'avatar' => "img/no-pict"
            ]);

            $firstnameTeacherIndex = array_rand($firstname);
            $lastnameTeacherIndex = array_rand($lastname);
            $phoneNumberTeacherIndex = array_rand($phoneNumber);
            $nameTeacher = $firstname[$firstnameTeacherIndex] . " " . $lastname[$lastnameTeacherIndex];
            $emailTeacher = strtolower($firstname[$firstnameTeacherIndex].$lastname[$lastnameTeacherIndex])."@schoolah.com";

            $teacherUser = User::create([
                'name' => $nameTeacher,
                'email' => $emailTeacher,
                'password' => bcrypt('schoolah'),
                'role' => 'teacher',
                'phone_number' => $phoneNumber[$phoneNumberTeacherIndex],
                'is_change_password' => false,
                'school_id' => 1,
                'address' => '-'
            ]);

            Teacher::create([
                'user_id' => $teacherUser->id,
                'teacher_code' => "TCRSUTOMO".$code,
                'avatar' => "img/no-pict"
            ]);

            $index++;

        }
    }
}
