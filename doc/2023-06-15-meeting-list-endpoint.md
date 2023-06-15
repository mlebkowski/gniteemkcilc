# Meeting list endpoint RFC

## Objective

As an API consumer,
I would like to access the list of meetings,
so that I can be happy and lead a fulfilling life!

### Acceptance criteria.

* name, start time and ratings are available for each item on the list
* the consumer may select from various ordering options,
  such as start date ascending, or name descending
* as well as filter by the status fields, and potentially

### Tech notes

The architecture needs to be elastic enough to support easy extensions

## Business context considerations

Since this is a recruitment task, and not a real business case, let’s have some fun!

## Proposed solution

Use API Platform.

*curb your enthusiasm music*

![](https://i.kym-cdn.com/entries/icons/original/000/027/525/robert.jpg)

## Obstacles

But for real, let’s get something serious out of this.
The system is fairly straightforward.
What is non-trivial, but still easy, is to consider:

### Calculating the rating

Since we only allow members to rate,
and there is a 5 member limit implemented (solid work, see pull #1),
the risk of high volumes of data is minimal.
But, requirements in other parts of the system might change over time,
so other approaches should be considered:

* first of all, if we were to join the ratings in real time,
  avoid n+1 problem and join them eagerly
* consider storing the average rate on the meeting entity / cache / other data store,
  so we don’t need to reach to raw data to calculate
  (that is sensible either way, but please, don’t ask me to add redis to the stack rn)
* use postgres, have materialized views or something like that

### Easy extensibility

A system… As a coding challenge… With custom sorting strategies 🤔
[That sounds familiar](https://phone.docplanner.com/php-coding-challenge.pdf).

So if I am not mistaken, the goal is to just use an interface and autowire it
in the container to allow us to fetch all implementations using `tagged_iterator`.
Yeah, [been there](https://github.com/mlebkowski/registry-compiler) — that’s my
lib from Symfony 2.x times, where there was no such thing out of the box, and
people needed to write their own CompilerPasses to get that result. So I created
an universal one, nvm.

But the solution has its flaws. Fist and foremost, nobody in their right mind
would sort the results in memory, so any practical implementations would be
sql-based, and unless you want to create a query-builder like abstraction,
the extensibility goes out of the window IMO. Well, of course we could tag
query builder adapters the same way in the container, just to show the point
that you know the feature. 🤷‍

### Where is the business logic?

The system has a logic of providing all those sorting and filtering strategies.
We might decide that it is trivial (in this case it probably is),
but the `tagged_iterator` feature is addictive, and we tend to overuse it IMO.

Then, instead of having factories in your domain responsible for proper assembly
of the final strategies, you push that logic out to the DIC, where it will be
tested in the e2e suite at best.

Instead, consider moving it back to concrete classes, to underline that this
logic — the ordering, metadata, concrete set of strategies — is important
to you. If it actually is, of course.

```php
final readonly class FooStrategyCollectionFactory {
    public function __construct(
       private FooStrategyAlpha $alpha,
       private FooStrategyBravo $bravo,
       private FooStrategyCharlie $charlie,
    ) {}
    
    public function getStrategies(): FooStrategy[] # a boy can dream!
    {
        yield $this->alpha;
        yield $this->bravo;
        yield $this->charlie;
    }
}
```

Yeah, I know, it’s boilerplate, but at one point you kind of get used to it
and start to like it. And it’s autowired, too, without any changes to the config!
