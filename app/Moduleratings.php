<?php



namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Moduleratings extends Model
{
    use HasTranslations;
    
    public $translatable = ['review'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
      $attributes = parent::toArray();
      
      foreach ($this->getTranslatableAttributes() as $name) {
          $attributes[$name] = $this->getTranslation($name, app()->getLocale());
      }
      
      return $attributes;
    } 

    protected $table = 'module_ratings'; 

    protected $fillable = [
        'course_id','chapter_id', 'user_id', 'accessibility', 'quality', 'support', 'review', 'status', 'approved', 
        'featured','qn1','qn2','qn3','qn4','qn5','qn6' ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    
    public function courses()
    {
        return $this->belongsTo('App\Course','course_id','id');
    }
}
 