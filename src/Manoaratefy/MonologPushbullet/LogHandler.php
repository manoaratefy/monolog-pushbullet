<?php declare(strict_types=1);
 
namespace Manoaratefy\MonologPushbullet;
 
use Monolog\Level;
use Monolog\Utils;
use Monolog\LogRecord;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;
 
class LogHandler extends AbstractProcessingHandler
{
    private const ENDPOINT_API = 'https://api.pushbullet.com/v2/';

    private string $accessToken;
    protected $title;
    protected $emails;

    /**
     * @param  string        $accessToken  Pushbullet access token
     * @param  string|array  $emails       Pushbullet email(s) account(s) to notify
     * @param  string        $title        Pushbullet notification title
     */
    public function __construct(string $accessToken, string|array $emails, string $title = '',int|string|Level $level = Level::Error, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->title = $title;
        $this->accessToken = $accessToken;

        if(is_array($emails))
        {
            $this->emails = $emails;
        }
        else
        {
            $this->emails = explode(',', $emails);
        }
    }

    protected function write(array $record): void
    {
        $this->send($record['formatted']);
    }

    /**
     * Send request to @link https://api.pushbullet.com/v2/ on SendMessage action.
     */
    protected function send(string $message): void
    {
        foreach ($this->emails as $email)
        {
            $response = Http::withHeaders([
                'Access-Token' => $this->accessToken,
            ])->post(self::ENDPOINT_API . 'pushes', [
                'type'  => 'note',
                'title' => $this->title,
                'body'  => $message,
                'email' => $email,
            ]);
        }
    }
}