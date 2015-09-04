<?php namespace Nimo\Bundled;

use Nimo\IMiddleware;

/**
 * User: mcfog
 * Date: 15/9/4
 */
class ConditionMiddleware extends AbstractWrapperMiddleware
{
    /**
     * @var callable
     */
    private $conditionCallback;

    function __construct(callable $conditionCallback, IMiddleware $innerMiddleware)
    {
        parent::__construct($innerMiddleware);
        $this->conditionCallback = $conditionCallback;
    }

    protected function main()
    {
        if ($this->invokeCallback($this->conditionCallback)) {
            $response = $this->invokeCallback($this->innerMiddleware);
        } else {
            $response = $this->response;
        }

        return $this->next(null, $response);
    }
}
