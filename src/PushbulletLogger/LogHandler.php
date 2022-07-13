<?php
 
namespace Manoaratefy\PushbulletLogger;
 
use Monolog\Level;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;
 
class LogHandler extends AbstractProcessingHandler
{
    private const ENDPOINT_API = 'https://api.pushbullet.com/v2/';

    /**
     * Pushbullet access token.
     */
    protected $accessToken;

    /**
     * Pushbullet notification title.
     */
    protected $title;

    /**
     * Pushbullet email to notify.
     */
    protected $emails;

    /**
     * @param  string        $accessToken  Pushbullet access token
     * @param  string|array  $emails       Pushbullet email(s) account(s) to notify
     */
    public function __construct(
        string $accessToken,
        string $emails,
        string $title = '',
        $level = Level::Debug,
        bool   $bubble = true
    ) {

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

    /**
     * @inheritDoc
     */
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
            Http::withHeaders([
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