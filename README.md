# Command And Event Structure for Slim

## Usage

In order to take advantage of the Command Bus and Event Bus, you will need to base your Controllers/Actions on the `AbstractAction` object

```php

public MyAction extends Infra\AbstractAction implements EventListenerInterface {
    protected $sent;
    
    public function __construct(CommandBus $bus) {
        parent::__construct($bus);
        
        $this->sent = false;
            
        //Register Our Action class as a listener for the SentEmailToUser Event
        $eventBus = $bus->getEventBus();
        $eventBus->addListener(SentEmailToUser::NAME, $this);
        //We are waiting for the domain model to return to us wether the email was sent or not.
        //We do not care about anything else, except whether or not it was successful.
    }
    
    //In this action we will Queue and Email to be sent.
    public function __invoke(Request $request, Response $response, array $args = []) {
        $this->commandBus->handle(new SendEmailToUser());
        
        //Return our response
        return $this->respond($response);
    }
    
    //We received the event mark it as a yes
    public function receiveEvent(SentEmailToUser $event) {
        $this->sent = true;
    }
    
    public function respond(Response $response) {
        if ($sent) { //Yes we did
            return $response->withJson(['message' => 'Sent Email to User']);
        } else { //No We did not.
            return $response->withJson(['message' => 'Sent Email to User'], 500);
        }
    }
    
    public function getCommands() {
        return []; //We are not queueing any other commands
    }

    public function getEvents() {
        return []; //We are not queuing any other events
    }
}

```