<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {

    Carbon::setLocale('fr');
    Blade::directive('money',function ($number){
     $valeur =  $number;
        return "<?php echo number_format($valeur, 0, ',', ' ')?>";
    });
  }
}
