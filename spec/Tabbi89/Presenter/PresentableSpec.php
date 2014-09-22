<?php

namespace spec\Tabbi89\Presenter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Tabbi89\Presenter\PresentableInterface;
use Tabbi89\Presenter\Presentable;
use Tabbi89\Presenter\PresenterNotFoundException;

class PresentableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(Foo::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Foo::class);
        $this->shouldImplement(PresentableInterface::class);
    }

    function it_throws_presenter_not_found_exception_when_presenter_path_is_wrong()
    {
        $this->beAnInstanceOf(FalseFoo::class);
        $this->shouldThrow(PresenterNotFoundException::class)->duringPresent();
    }

    function it_throws_presenter_not_found_exception_when_no_presenter_is_set()
    {
        $this->beAnInstanceOf(SimpleFalseFoo::class);
        $this->shouldThrow(PresenterNotFoundException::class)->duringPresent();
    }

    function it_returns_view_specified_logic()
    {
        $this->present()->getName()->shouldReturn('foo');
    }
}

class FalseFoo implements PresentableInterface
{
    use Presentable;

    public $name = 'Foo';

    public function getPresenter()
    {
        return 'WrongPresenter';
    }
}

class SimpleFalseFoo
{
    use Presentable;

    public $name = 'Foo';
}

class Foo implements PresentableInterface
{
    use Presentable;

    public $name = 'Foo';

    public function getPresenter()
    {
        return FooPresenter::class;
    }
}

class FooPresenter
{
    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    public function getName()
    {
        return strtolower($this->foo->name);
    }
}
