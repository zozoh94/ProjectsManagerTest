<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    public $timestamps = false;

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'clientCompanyName', 'performerCompanyName', 'startDate', 'endDate', 'priority', 'leader_id', 'comment'];

    protected $hidden = ['leader_id'];
    
    public function leader()
    {
        return $this->belongsTo('App\Employee');
    }
    
    public function performers()
    {
        return $this->belongsToMany('App\Employee');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function scopeSearch($query, $search)
    {
        $betweenDate1 = new Carbon($search['betweenDate1']);
        $betweenDate2 = new Carbon($search['betweenDate2']);   
        $betweenDate2 = $betweenDate2->hour('23')->minute('59')->second('59');                
        $query            
            ->with('leader', 'performers')
            ->whereBetween('startDate', [$betweenDate1, $betweenDate2])     
            ->where('priority', '>=', $search['minPriority']);     
        if($search['q']) {            
            $query->where(function($q) use ($search) {                
                $keywords = explode(' ', $search['q']);
                foreach($keywords as $keyword) {
                    $q->whereRaw('LOWER("name") LIKE ?', array(strtolower($keyword).'%'));
                    $q->orWhereRaw('LOWER("clientCompanyName") LIKE ?', array(strtolower($keyword).'%'));
                    $q->orWhereRaw('LOWER("performerCompanyName") LIKE ?', array(strtolower($keyword).'%'));                    
                    $q->orWhereHas('leader', function($q2) use($keyword) {
                        $q2->whereRaw('LOWER("firstname") LIKE ?', array(strtolower($keyword).'%'));
                        $q2->orWhereRaw('LOWER("lastname") LIKE ?', array(strtolower($keyword).'%'));
                        $q2->orWhereRaw('LOWER("email") LIKE ?', array(strtolower($keyword).'%'));
                    });
                    $q->orWhereHas('performers', function($q2) use($keyword) {
                        $q2->whereRaw('LOWER("firstname") LIKE ?', array(strtolower($keyword).'%'));
                        $q2->orWhereRaw('LOWER("lastname") LIKE ?', array(strtolower($keyword).'%'));
                        $q2->orWhereRaw('LOWER("email") LIKE ?', array(strtolower($keyword).'%'));
                    });
                }                
            });
        }

        $query->orderBy($search['sortBy'], $search['sortDir']);
        
        return $query;
    }
}