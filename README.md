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
    }
    
    //In this action we will Queue and Email to be sent.
    public function __invoke(Request $request, Response $response, array $args = []) {
        $this->commandBus->handle(new SendEmailToUser());
        
        return $this->respond($response);
    }
    
    public function receiveEvent(SentEmailToUser $event) {
        $this->sent = true;
    }
    
    public function respond(Response $response) {
        if ($sent) {
            return $response->withJson(['message' => 'Sent Email to User']);
        } else {
            return $response->withJson(['message' => 'Sent Email to User'], 500);
        }
    }
    
    public function getCommands() {
        return [];
    }

    public function getEvents() {
        return [];
    }
}

```