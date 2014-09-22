<?php

namespace Tabbi89\Presenter;

/**
 * Trait Presentable
 *
 * Allows to present view specified logic
 *
 * <code>
 * class Foo implements PresentableInterface
 * {
 *     use Presentable;
 *     public function getPresenter()
 *     {
 *         return 'FooPresenter';
 *     }
 *     # ...
 * }
 *
 * class FooPresenter
 * {
 *     public __construct(Foo $foo)
 *     {
 *         $this->foo = $foo;
 *     }
 *
 *      public function getFullName()
 *      {
 *          return $this->foo->getName . $this->foo->getLastName;
 *      }
 * }
 *
 * $foo = new Foo()
 * $fullName = $foo->present()->getFullName();
 * </code>
 *
 * @package Tabbi89\Presenter
 * @author  Tabbi89 <tom@tabbi89.com>
 */
trait Presentable
{
    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     *
     * @throws PresenterNotFoundException
     */
    public function present()
    {
        if (!$this instanceof PresentableInterface || !class_exists($this->getPresenter())) {
             throw new PresenterNotFoundException('Please set the property to correct presenter path or implement presentable interface');
        }

        if (!$this->presenterInstance) {
            $presenter = $this->getPresenter();
            $this->presenterInstance = new $presenter($this);
        }

        return $this->presenterInstance;
    }
}
