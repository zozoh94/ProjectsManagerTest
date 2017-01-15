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
                    $q->where('name', 'LIKE', $keyword.'%');
                    $q->orWhere('clientCompanyName', 'LIKE', $keyword.'%');
                    $q->orWhere('performerCompanyName', 'LIKE', $keyword.'%');
                    $q->orWhereHas('leader', function($q2) use($keyword) {
                        $q2->where('firstname', 'LIKE', $keyword.'%');
                        $q2->orWhere('lastname', 'LIKE', $keyword.'%');
                        $q2->orWhere('email', 'LIKE', $keyword.'%');
                    });
                    $q->orWhereHas('performers', function($q2) use($keyword) {
                        $q2->where('firstname', 'LIKE', $keyword.'%');
                        $q2->orWhere('lastname', 'LIKE', $keyword.'%');
                        $q2->orWhere('email', 'LIKE', $keyword.'%');
                    });
                }                
            });
        }

        $query->orderBy($search['sortBy'], $search['sortDir']);
        
        return $query;
    }
}