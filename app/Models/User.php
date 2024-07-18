<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


// app/Models/User.php

    public function completedSlides()
    {
        return $this->belongsToMany(Slide::class, 'completed_slides')->withTimestamps();
    }

    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'completed_lessons')->withTimestamps();
    }

    public function hasCompletedSlide(Slide $slide)
    {
        return $this->completedSlides()->where('slide_id', $slide->id)->exists();
    }

    public function hasCompletedLesson(Lesson $lesson)
    {
        return $this->completedLessons()->where('lesson_id', $lesson->id)->exists();
    }

    public function completeSlide(Slide $slide)
    {
        if (!$this->hasCompletedSlide($slide)) {
            $this->completedSlides()->attach($slide);
        }
    }

    public function completeLesson(Lesson $lesson)
    {
        if (!$this->hasCompletedLesson($lesson)) {
            $this->completedLessons()->attach($lesson);
        }
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'bookmarks');
    }

    public function completedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'completed_courses')->withTimestamps();
    }

    public function hasCompletedCourse(Course $course)
    {
        return $this->completedCourses()->where('course_id', $course->id)->exists();
    }

    public function completeCourse(Course $course)
    {
        if (!$this->hasCompletedCourse($course)) {
            $this->completedCourses()->attach($course);
        }
    }




}
