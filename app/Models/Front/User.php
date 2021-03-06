<?php

/**
 * User Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    User
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Http\Start\Helpers;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Front\Messages;
use App\Models\Front\Language;
use Laravel\Cashier\Billable;
use DateTime;
use Session;
use Carbon;
/**
 * App\Models\Front\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $user_type
 * @property string|null $remember_token
 * @property string $dob
 * @property string|null $gender
 * @property string $live
 * @property string $about
 * @property string|null $website
 * @property string $school
 * @property string                                                                        $work
 * @property string                                                                        $timezone
 * @property string                                                                        $languages
 * @property string|null                                                                   $fb_id
 * @property string|null                                                                   $google_id
 * @property string|null                                                                   $linkedin_id
 * @property string|null                                                                   $currency_code
 * @property string|null                                                                   $status
 * @property string                                                                        $property_manager
 * @property string|null                                                                   $access_code
 * @property string|null                                                                   $ip_address
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property \Carbon\Carbon|null                                                           $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Chats[]             $chats
 * @property-read mixed                                                                    $age
 * @property-read mixed                                                                    $dispute_messages_count
 * @property-read mixed                                                                    $dob_dmy
 * @property-read mixed                                                                    $full_name
 * @property-read mixed                                                                    $languages_name
 * @property-read mixed                                                                    $primary_phone_number
 * @property-read mixed                                                                    $primary_phone_number_protected
 * @property-read mixed                                                                    $since
 * @property-read mixed                                                                    $user_currency_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Post[]              $posts
 * @property-read \App\Models\Front\ProfilePicture                                               $profile_picture
 * @property-read \App\Models\Front\Referrals                                                    $referrals
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Reviews[]           $reviews
 * @property-read \App\Models\Front\SavedWishlists                                               $saved_wishlists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\UsersPhoneNumbers[] $users_phone_numbers
 * @property-read \App\Models\Front\UsersVerification                                            $users_verification
 * @property-read \App\Models\Front\Wishlists                                                    $wishlists
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Front\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereFbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User wherePropertyManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\User whereWork($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Front\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Front\User withoutTrashed()
 * @method create( array $all )
 * @mixin \Eloquent
 * @property-read mixed $active_users
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword, Impersonate;
	use Billable;
	// use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','first_name', 'last_name', 'email', 'password', 'dob', 'status', 'gender', 'live', 'about', 'school'
		, 'work', 'timezone', 'languages', 'website','property_manager', 'last_login_time'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $appends = ['dob_dmy','age','full_name', 'primary_phone_number_protected', 'primary_phone_number', 'languages_name','user_currency_code','since'];

	// protected $dates = ['deleted_at'];


	/**
	 * check online status of user
	 */
	public function is_online(){
	 
		$last_login_time = $this->last_login_time;
		// return $diff = abs(strtotime(date('Y-m-d H:i:s')) - strtotime($last_login_time));
	 
	 
		$timeFirst  = strtotime($last_login_time);
		$timeSecond = strtotime(date('Y-m-d H:i:s'));
		if($timeSecond > 5){
			return 0;
		}
		else{
			return 1;
		}
		return $differenceInSeconds = $timeSecond - $timeFirst;
		return $diff = $date2->getTimestamp() - $date->getTimestamp();
		$date = new DateTime($last_login_time);
		$now = new DateTime();
		$today=Carbon::now();
		// $since_start= $date->diff($now)->format("%s");
		return $today->diffForHumans($last_login_time);
		if($since_start > 10){
			return false;
		}
		else{
			return true;
		}
	}
	/**
	 * Sanitize First Name field
	 * @param $input
	 */
	public function setFirstNameAttribute($input){
		$this->attributes['first_name'] = strip_tags($input);
	}

	/**
	 * Sanitize last name field
	 * @param $input
	 */
	public function setLastNameAttribute($input){
		$this->attributes['last_name'] = strip_tags($input);
	}

	/**
	 * Encrypt password using Bcrypt
	 * @param $password
	 * @uses \Illuminate\Hashing\BcryptHasher
	 */
	public function setPasswordAttribute($password) {
		$this->attributes['password'] = bcrypt($password);
	}

	/**
	 * set user timezone
	 * @param $input
	 */
	public function setTimezoneAttribute($input) {
		$this->attributes['timezone'] = ( new Helpers )->getUserTimeZone($input);
	}


	/**
	 * A user can have many messages
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function chats()
	{
		//return $this->hasMany(Chats::class);
		return $this->hasMany('App\Models\Front\Chats','user_id','id');
	}

	// Join with profile_picture table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function profile_picture()
	{
		return $this->belongsTo('App\Models\Front\ProfilePicture','id','user_id');
	}

	// Join with users_verification table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users_verification()
	{
		return $this->belongsTo('App\Models\Front\UsersVerification','id','user_id');
	}

	// Join with users_phone_numbers table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users_phone_numbers()
	{
		return $this->hasMany('App\Models\Front\UsersPhoneNumbers','user_id','id');
	}

	// Join with saved_wishlists table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function saved_wishlists()
	{
		return $this->belongsTo('App\Models\Front\SavedWishlists','id','user_id');
	}

	// Join with wishlists table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function wishlists()
	{
		return $this->belongsTo('App\Models\Front\Wishlists','id','user_id');
	}

	// Join with referrals table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function referrals()
	{
		return $this->belongsTo('App\Models\Front\Referrals','id','user_id');
	}

	// Inbox unread message count

	/**
	 * @return int
	 */
	public function inbox_count()
	{
		return Messages::where('user_to', $this->attributes['id'])->where('read', 0)->count();
	}

	// Join with reviews table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function reviews()
	{
		return $this->hasMany('App\Models\Front\Reviews','user_to','id');
	}

	//Posts

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts(){
		return $this->hasMany( 'App\Models\Front\Post', 'author_id', 'id' );
	}

//	/**
//	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//	 */
//	public function property_manager(){
//		return $this->belongsTo( 'App\Models\Front\PropertyManager', 'id', 'user_id');
//	}

	// Get status Active users count

	/**
	 * @return int
	 */
	public static function count()
	{
		return DB::table('users')->whereStatus('Active')->count();
	}

	/**
	 * Restrict which users are allowed to impersonate
	 * @return bool
	 *
	 */
	public function canImpersonate()
	{
		//get referrals
		if($this->attributes['property_manager'] == 'Yes'){
			$referrers = Referrals::where('user_id', $this->attributes['id']);
			return $referrers;
		}
		return false;

	}

	/**
	 *  Restrict which users can be impersonated
	 * @return bool
	 */
	public function canBeImpersonated()
	{
		//get referrals for the current user id & check if the friend_id matches the impersonate id
		$referrals = Referrals::where('user_id', $this->attributes['id'])->where('friend_id', $this->id);
		return $referrals;
	}


	/**
	 * User has verified phone
	 * @return bool
	 */
	public function hasVerifiedPhone()
	{
		$users_phone_numbers = UsersPhoneNumbers::where('user_id', $this->attributes['id'])->where('status', 'Confirmed')->first();
		if($users_phone_numbers) {
			return true;
		}
		return false;
	}




	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getReferralsAttribute() {
		$referrer = Referrals::where('user_id', $this->attributes['id']);

		return $referrer->get();
	}


	/**
	 * @return mixed
	 */
	public function getActiveUsersAttribute() {
		return $this->whereStatus('Active')->get();
	}

	// Convert y-m-d date of birth date into d-m-y

	/**
	 * @return false|string
	 */
	public function getDobDmyAttribute()
	{
		if(@$this->attributes['dob'] != '0000-00-00')
			return date('Y-m-d', strtotime(@$this->attributes['dob']));
		else
			return '';
	}

	/**
	 * @return int
	 */
	public function getAgeAttribute()
	{
		$dob = @$this->attributes['dob'];
		if(!empty($dob) && $dob != '0000-00-00')
		{
			$birthdate = new DateTime($dob);
			$today   = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * @return mixed
	 */
	public function getPrimaryPhoneNumberProtectedAttribute(){
		$primary_phone_number_protected = '';
		$users_phone_numbers = UsersPhoneNumbers::where('user_id', $this->attributes['id'])->where('status', 'Confirmed')->first();
		return @$users_phone_numbers->phone_number_protected;
	}

	/**
	 * @return mixed
	 */
	public function getPrimaryPhoneNumberAttribute(){
		$primary_phone_number = '';
		$users_phone_numbers = UsersPhoneNumbers::where('user_id', $this->attributes['id'])->where('status', 'Confirmed')->first();
		if(!$users_phone_numbers) {
			$users_phone_numbers = UsersPhoneNumbers::where('user_id', $this->attributes['id'])->first();
		}
		return @$users_phone_numbers->phone_number_full;
	}

	/**
	 * @return false|string
	 */
	public function getSinceAttribute()
	{
		return date('Y', strtotime($this->attributes['created_at']));
	}

	/**
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return ucfirst(@$this->attributes['first_name']).' '.ucfirst(@$this->attributes['last_name']);
	}

	/**
	 * @return string
	 */
	public function getFirstNameAttribute()
	{
		return ucfirst($this->attributes['first_name']);
	}

	/**
	 * @return string
	 */
	public function getLastNameAttribute()
	{
		return ucfirst($this->attributes['last_name']);
	}

	//

	/**
	 * get user currency code
	 * @return mixed
	 */
	public function getUserCurrencyCodeAttribute()
	{
		if(@$this->attributes['currency_code']!=null){
			return @$this->attributes['currency_code'];
		}
		else{
			return DB::table('currency')->where('default_currency', 1)->first()->code;
		}
	}


	/**
	 * get user currency code
	 * @return mixed
	 */
	public function getCurrencyCodeAttribute()
	{
		if(@$this->attributes['currency_code']!=null){
			return @$this->attributes['currency_code'];
		}
		else{
			return DB::table('currency')->where('default_currency', 1)->first()->code;
		}
	}

	/**
	 * @param $email
	 * @param $fb_id
	 *
	 * @return \App\Models\Front\User
	 */
	public static function user_facebook_authenticate($email, $fb_id){
		$user = User::where(function($query) use($email, $fb_id){
			$query->where('email', $email)->orWhere('fb_id', $fb_id);
		});
		return $user;
	}

	/**
	 * @param $user_id
	 *
	 * @return bool
	 */
	public static function clearUserSession($user_id){
		$session_id = Session::getId();

		$sessions = DB::table('sessions')->where('user_id', $user_id)->where('id', '!=', $session_id)->delete();

		$current_session = DB::table('sessions')->where('id', $session_id)->first();
		if($current_session){
			$current_session_data = unserialize(base64_decode($current_session->payload));
			foreach ($current_session_data as $key => $value) {
				if('login_user_' == substr($key, 0, 11)){
					if(Session::get($key) == $user_id){
						Session::forget($key);
						Session::save();
						DB::table('sessions')->where('id', $session_id)->update(array('user_id' => NULL));;
					}
				}
			}
		}
		return true;
	}

	/**
	 * @return string
	 */
	public function getLanguagesNameAttribute()
	{
		// var_dump($this->attributes['languages']->toString());exit;
		$languages = explode(',', $this->attributes['languages']);
		$languages_name = '';
		if($this->attributes['languages']) {
			foreach($languages as $row) {
				$languages_name .= Language::find($row)->name.',';
			}
		}
		return rtrim($languages_name,',');
	}

	/**
	 * @return false|string
	 */
	public function getCreatedAtAttribute(){
		return date('Y-m-d'.' H:i:s',strtotime($this->attributes['created_at']));
	}

	/**
	 * @return false|string
	 */
	public function getUpdatedAtAttribute(){
		if($this->attributes['updated_at']=="0000-00-00 00:00:00")
		{
			return date('Y-m-d'.' H:i:s',strtotime($this->attributes['created_at']));
		}
		else
		{
			return date('Y-m-d'.' H:i:s',strtotime($this->attributes['updated_at']));
		}

	}

	/**
	 * @return \App\Models\Front\UsersPhoneNumbers|\Illuminate\Database\Eloquent\Model|null|object
	 */
	public function primaryPhone() {
return "123456789";
		$primary_phone = UsersPhoneNumbers::where('user_id', $this->id)->where('status', 'Confirmed')->first();
		if(!$primary_phone) {
			$primary_phone = UsersPhoneNumbers::where('user_id', $this->id)->first();
		}
		return $primary_phone;
	}

	/**
	 * @return mixed
	 */
	public function dispute_messages()
	{
		return DisputeMessages::userReceived($this->attributes['id'])->unread()->get();
	}

	/**
	 * @return mixed
	 */
	public function getDisputeMessagesCountAttribute()
	{
		return $this->dispute_messages()->count();
	}

	public function previous_membership(){
		return Subscriptions::where('user_id', $this->id)->orderBy('id', 'desc')->first()->name;
	}
	public function subscriptions()
    {
        return $this->hasMany(Subscriptions::class)->orderBy('created_at', 'desc');
    }
}
