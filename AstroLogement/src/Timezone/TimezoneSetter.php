namespace App\Timezone;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class TimezoneSetter
{
    public function __invoke(RequestEvent $event): void
    {
        date_default_timezone_set('Europe/Paris');
    }
}
