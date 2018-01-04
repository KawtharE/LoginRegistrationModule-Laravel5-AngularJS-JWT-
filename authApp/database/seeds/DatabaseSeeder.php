<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('users')->delete();
        $users = array(
        		['firstName'=>'Kaouther', 'lastName'=>'Mefteh', 'Age'=>'25', 'email'=>'meftehkaouther@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Tommie', 'lastName'=>'Seese', 'Age'=>'35', 'email'=>'TommieSeese@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Daine', 'lastName'=>'Voorhies', 'Age'=>'19', 'email'=>'DaineVoorhies@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Lewis', 'lastName'=>'Tawney', 'Age'=>'42', 'email'=>'LewisTawney@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Ling', 'lastName'=>'Craft', 'Age'=>'31', 'email'=>'LingCraft@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Stephenie', 'lastName'=>'Noguera', 'Age'=>'20', 'email'=>'StephenieNoguera@gmail.com', 'password'=>bcrypt('123456789')],
        		['firstName'=>'Rodrigo', 'lastName'=>'Tulloch', 'Age'=>'50', 'email'=>'RodrigoTulloch@gmail.com', 'password'=>bcrypt('123456789')] ,
                ['firstName'=>'Rod', 'lastName'=>'Byerley', 'Age'=>'17', 'email'=>'RodByerley@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Esteban', 'lastName'=>'Upshur', 'Age'=>'21', 'email'=>'EstebanUpshur@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Karrie', 'lastName'=>'Alvin', 'Age'=>'33', 'email'=>'KarrieAlvin@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Sheena', 'lastName'=>'Rohrbaugh', 'Age'=>'41', 'email'=>'SheenaRohrbaugh@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Maragret', 'lastName'=>'Monk', 'Age'=>'63', 'email'=>'MaragretMonk@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Irvin', 'lastName'=>'Owings', 'Age'=>'29', 'email'=>'IrvinOwings@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Glynis', 'lastName'=>'Curatolo', 'Age'=>'31', 'email'=>'GlynisCuratolo@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Kasha', 'lastName'=>'Debow', 'Age'=>'20', 'email'=>'KashaDebow@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Lyndia', 'lastName'=>'Althouse', 'Age'=>'22', 'email'=>'LyndiaAlthouse@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Ken', 'lastName'=>'Ken Fagundes', 'Age'=>'37', 'email'=>'KenFagundes@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Raguel', 'lastName'=>'Eddington', 'Age'=>'35', 'email'=>'RaguelEddington@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Scott', 'lastName'=>'Scott Troia', 'Age'=>'25', 'email'=>'ScottTroia@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Jarred', 'lastName'=>'Lively', 'Age'=>'36', 'email'=>'JarredLively@gmail.com', 'password'=>bcrypt('123456789')],
                ['firstName'=>'Ramona', 'lastName'=>'Davenport', 'Age'=>'28', 'email'=>'RamonaDavenport@gmail.com', 'password'=>bcrypt('123456789')]       		
        	);
        foreach($users as $user){
        	User::create($user);
        }
        Model::reguard();
    }
}
