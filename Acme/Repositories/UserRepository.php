<?php

namespace Acme\Repositories;
use Carbon\Carbon;
use Acme\Helper\AesTrait;
use App\PersonalInfo;
use App\RoleUser;
use App\Role;
use App\UserMeta;
use Illuminate\Support\Facades\Validator;
use Acme\Helper\StateHelper;

class UserRepository extends Repository{

    const LIMIT                 = 20;
    const INPUT_DATE_FORMAT     = 'Y-m-d';
    const OUTPUT_DATE_FORMAT    = 'F d,Y';


    use AesTrait, StateHelper;

    protected $listener;

    private $inflationRate      = 0.03;
    private $growthRate         = 0.06;
    private $inputAttributes    = [];

    public function model(){
        return 'App\User';
    }

    public function setListener($listener){
        $this->listener = $listener;
    }

    public function setDate($date){
        return date('Y-m-d', strtotime($date));
    }

    public function getUsers($request)
    {
        $query = $this->model->leftJoin('personal_infos', 'personal_infos.user_id', '=', 'users.id');
        if ($request->has('search')) {
            $search = trim($request->input('search'));
            $query = $query->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('nickname', 'LIKE', '%' . $search . '%')
                    ->orWhere('gender', 'LIKE', '%' . $search . '%')
                    ->orWhere('position', 'LIKE', '%' . $search . '%');
            });
        }

        $order_by   = ($request->input('order_by')) ? $request->input('order_by') : 'id';
        $sort       = ($request->input('sort'))? $request->input('sort') : 'desc';

        return $query->select('users.*')
            ->orderBy('users.'.$order_by, $sort)
            ->get();
    }

    public function getClients($request){
        $query          = Role::find(2)->users();
        if($request->has('search')){
            $search     = trim($request->input('search'));
            $query->where(function($query) use ($search){
                $query->where('first_name','LIKE','%'.$search.'%')
                    ->orWhere('last_name','LIKE','%'.$search.'%')
                    ->orWhere('nickname','LIKE','%'.$search.'%')
                    ->orWhere('gender','LIKE','%'.$search.'%');
            });
        }

        $order_by   = ($request->input('order_by')) ? $request->input('order_by') : 'id';
        $sort       = ($request->input('sort'))? $request->input('sort') : 'desc';

        return $query->orderBy($order_by, $sort)->get();
    }

    public function create(){

        $data['action']         = route('user_store');
        $data['action_name']    = 'Add';

        $data['email']          = old('email');
        $data['first_name']     = old('first_name');
        $data['last_name']      = old('last_name');
        $data['nickname']       = old('nickname');
        $data['status']         = old('status');
        $data['birthdate']      = old('birthdate');
        $data['gender']         = old('gender');
        $data['position']       = old('position');
        $data['date_hired']     = old('date_hired');

        return $data;
    }

    public function assign_role($request, $id){
        if(RoleUser::where('user_id',$id)->first()){
            RoleUser::where('user_id',$id)->update(['role_id' => $request]);
        }else{
            $this->model->where('id', $id)->first()->assignedRole($request);
        }

    }

    public function save($request, $id = 0){
        $action     = ($id == 0) ? 'user_create' : 'user_edit';

        $input      = $request->except(['_token','confirm']);

        $messages   = [
            'required' => 'The :attribute is required',
        ];
        $validator  = Validator::make($input, [
            'first_name'    => 'required',
            'last_name'     => 'required',
        ], $messages);

        if($validator->fails()){
            return $this->listener->failed($validator, $action, $id);
        }

        if($input['password'] != ''){
            $input['password']  = bcrypt($input['password']);
        }else{
            unset($input['password']);
        }

        if($id == 0){
            $this->model->create($input);
            $this->model->orderBy('created_at', 'desc')->first()->assignRole(2);
            $this->listener->setMessage('User is successfully created!');
        }else{

            $this->model->where('id',$id)->update($input);
            $this->listener->setMessage('User is successfully updated!');
        }

        return $this->listener->passed($action, $id);
    }

    public function edit($id){
        $data['action']         = route('user_update', $id);
        $data['action_name']    = 'Edit';

        $user                   = $this->model->find($id);
        $p_info                 = PersonalInfo::where('user_id', $id)->first();

        $data['email']          = (is_null(old('email'))?$user->email:old('email'));
        $data['first_name']     = (is_null(old('first_name'))?$user->first_name:old('first_name'));
        $data['last_name']      = (is_null(old('last_name'))?$user->last_name:old('last_name'));
        $data['password']       = (is_null(old('password'))?$user->password:old('password'));
        $data['status']         = (is_null(old('status'))?$user->status:old('status'));

        if(is_object($p_info)){
            $data['gender']     = (is_null(old('gender'))?$p_info->gender:old('gender'));
            $data['birthdate']  = $this->getDate((is_null(old('birthdate'))?$p_info->birthdate:old('birthdate')));
            $data['position']   = (is_null(old('position'))?$p_info->birthdate:old('position'));
            $datehired          = (is_null(old('date_hired'))?$p_info->date_hired:old('date_hired'));

            $data['date_hired'] = Carbon::createFromFormat(self::OUTPUT_DATE_FORMAT, $datehired);
        }else{
            $data['gender']     = old('gender');
            $data['birthdate']  = old('birthdate');
            $data['position']   = old('position');
            $data['date_hired'] = old('date_hired');
        }

        return $data;
    }

    /*public function update(array $request, $id){
        $this->model->find($id)->update($request);
    }*/

    public function show($id){
        return $this->model->find($id);
    }


    public function destroy($id){
        $this->model->where('id',$id)->delete();
        PersonalInfo::where('user_id',$id)->delete();
    }


    
    public function signupSave($input){
        $this->inputAttributes      = $input;
        $user                       = [];
        $cashValue                  = $input['cash_value'];
        $insurance                  = 0;
        $insuranceScore             = 0;
        $legacy                     = 0;
        $legacyScore                = 0;
        $haveWill                   = 'No';
        $emergencyFund              = $input['what_is_the_total_value_of_your_emergency_fund'];
        $annuityIncome              = $input['annual_income'];//annual_income
        $pensionIncome              = 0;
//        $monthlyPayment             = $input['monthly_payment'];
        $monthlyPayment             = $input['estimated_montlhy_living_expenses'];
        $ssnYours                   = $input['social_security_retirement_benefit_yours'];
        $ssnSpouse                  = $input['social_security_retirement_benefit_spouse'];
        $GemWorthSemiPrivate        = 220; //Per day
        $n                          = 10;
        $incomeTarget               = 0;
        $taxFree                    = $input['pre_tax_income'];
        $assumeInterestRate         = $input['assume_interest_rate'];
        $taxDeffered                = $input['tax_deffered'];
        $effectiveTaxRate           = $input['effective_tax_rate'];
        $totalLifeInsuranceNeed     = 0;
        $emergencyFund              = $input['what_is_the_total_value_of_your_emergency_fund'];
        $emergencyFundScore         = 0;
        $estimatedMonthlyExpenses   = $input['estimated_montlhy_living_expenses'];
        $afterTaxIncome             = $input['in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement'];
        $partTimeEstimatedIncome    = $input['estimated_income'];

        $income                     = $input['in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement'];
//        return $this->cryptoJsAesDecrypt($input['phrase'], $input['password']);
        if(isset($input['pension'])){

            $myfinalarray = array();
            foreach ($input['pension'] as $key => $value) {
                foreach ($value as $k => $v) {
                    $myfinalarray[$k][$key] = $v;
                }
            }

        }


//        $income                     = $input['estimate_after_tax_monthly_income'] + $partTimeEstimatedIncome ;
//
//        $nMonthsIncomeAvailable     = 0;
//
//        $liquidityScore             = 0;
//
//        $LTCLiability               = 0;
//        $incomePerMonth             = $input['estimate_after_tax_monthly_income'];
//        $sumOfDeptPaymentPerMonth   = 0;
//        $MAR                        = 0;
//        $RiderBenefit               = $input['how_mush_is_the_annual_amount_on_the_rider'] + $input['annual_death_benefit_you_can_access'];
//        $rider                      = 0;
//        $trueRiskFormula            = 0;
//        $absoluteValue              = 0;
//        $highNetWorth               = 0;
//        $notHighNetWorth            = 0;
//        $age                        = $input['age'];
//        $spouseAge                  = $input['spouse_age'];
//        $maxAge                     = 100;
//        $incomeGoalArray            = $this->getIncomeGoal($age, $spouseAge);
//        $incomeGoal                 = 100000;
//
//        $geometricReturn            = sqrt(1);
//
//
//
//
//        if(in_array($input['state'], $this->getStates())){
//            $insuranceScore         += 40;
//        }
//
//        if($input['do_you_have_a_will'] == 'Yes'){
//            $highNetWorth        += 30;
//            $notHighNetWorth     += 50;
//        }
//
//        if($input['do_you_have_healthcare_proxy'] == 'Yes'){
//            $highNetWorth        += 20;
//            $notHighNetWorth     += 25;
//        }
//
//        if($input['do_you_have_power_of_attorney'] == 'Yes'){
//            $highNetWorth        += 20;
//            $notHighNetWorth     += 25;
//        }
//
//        if($input['do_you_have_life_insurance'] == 'Yes'){
//            $insuranceScore += 40;
//        }
//
//        if($input['do_you_have_disability_insurance'] == 'Yes'){
//            $insuranceScore += 5;
//        }
//
//        if($input['do_you_have_health_insurance'] == 'Yes'){
//            $insuranceScore += 5;
//        }
//
//        if($input['do_you_have_home_owners_insurance'] == 'Yes'){
//            $insuranceScore += 5;
//        }
//
//        $LTCLiability               = $GemWorthSemiPrivate * ($n * 1.5);
//        $initialEquation            = $annuityIncome +  $ssnYours + $pensionIncome + ($taxFree * $assumeInterestRate) + ($taxDeffered * $assumeInterestRate * (1 - $effectiveTaxRate));
//        $passiveIncome              = $initialEquation;
//        $LTCNeed                    = $LTCLiability - $passiveIncome - $RiderBenefit;
//        $LTCScore                   = $LTCLiability / $LTCNeed;
//
//        $lifeInsuranceIncome        = $incomeTarget - $passiveIncome;
//        $totalLifeInsuranceNeed     = $lifeInsuranceIncome / $assumeInterestRate;
//
//        $debtScore                  = ($sumOfDeptPaymentPerMonth / $incomePerMonth) * (-150);
//
//        if($emergencyFund < ( 6 * $income )){
//            $emergencyFundScore      = ((6 * $income) - $nMonthsIncomeAvailable ) * 10;
//        }else{
//            $emergencyFundScore      = ((6 * $income) - $nMonthsIncomeAvailable ) * 5;
//        }
//
//        //liquidity
//        $liquidityScore             = 100 - $emergencyFundScore - $debtScore;
//
//        $trueRiskFormula            = ($geometricReturn - $this->inflationRate - $MAR ) / $absoluteValue;
//        $discountRate               = $MAR + $this->inflationRate;

        $user['first_name']     = $input['first_name'];
        $user['last_name']      = $input['last_name'];
        $user['email']          = $input['email'];
        $user['password']       = bcrypt($this->cryptoJsAesDecrypt($input['phrase'], $input['password']));

        $user                   = $this->model->create($user);

//        $user_meta              = [];
        $unset_keys             = ['first_name','last_name','email','password','phrase','confirm','step', '_token'];

        foreach($unset_keys as $key)
        {
            unset($input[$key]);
        };

        if($user){

            $meta               = $this->model->find($user->id);
            foreach($input as $key => $value){
                if(!is_array($value)){
//                    $user_meta[]      = ['option' => $key, 'value' => $value];
                    $meta->usermeta()->create(['option' => $key, 'value' => $value]);
                }
            }

            $meta->usermeta()->create(['option' => 'pension', 'value' => serialize($input['pension'])]);
            $meta->usermeta()->create(['option' => 'children', 'value' => serialize($input['child'])]);
            $meta->usermeta()->create(['option' => 'investments', 'value' => serialize($input['investments'])]);
            $meta->usermeta()->create(['option' => 'assets', 'value' => serialize($input['asset'])]);
            $meta->usermeta()->create(['option' => 'liabilities', 'value' => serialize($input['asset'])]);

        }

        return $user;
    }

    public function getIncomeGoal($age, $spouseAge = 0){
        $incomeGoalArray            = [];
        $incomeGoal                 = 100000;
        $maxAge                     = 100;
        if($age > 31 || $spouseAge > 29){
            $incomeGoalArray[]        = 0;

            for($j = 31; $j <= $age; $j++){
                $incomeGoal             += $incomeGoal * ( 1+ $this->inflationRate);
            }
        }

        for($x = $age; $x <= $maxAge; $x++){
            $incomeGoal             += $incomeGoal * ( 1+ $this->inflationRate);
            $incomeGoalArray[]      = [
                'age' => $x, 'income_goal' => $incomeGoal
            ];
        }

        return $incomeGoalArray;
    }

    public function getBrokerageAccount(){
        $initialValue       = 10000.00;
    }

    public function getHusband401k(){
        $initialValue       =  48196.00;

    }

    public function getWife401k(){
        $initialValue       =  5000.00;
    }

    public function getHusbandIRA(){
        $initialValue       = 19416.00;

    }

    public function getWifeRoth(){
        $initialValue       =  24230.00;

    }

    public function checkEmail($email){
        $result = $this->model->where('email', '=', $email)->first();

        if($result){
            return ['status' => 0, 'message' => 'Email is already exists!'];
        }

        return ['status' => 1];
    }

}



