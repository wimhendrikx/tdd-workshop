<?php

namespace App\Test\Entity;


use App\Model\TaskEntity;
use App\Model\TaskEntityInterface;
use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    /**
     * Test to see that defaults are correctly set when instantiating
     * a new task entity.
     *
     * @covers TaskEntity::__construct
     */
    public function testTaskEntityIsEmptyAtConstruction()
    {
        $task = new TaskEntity();
        $this->assertInstanceOf(TaskEntityInterface::class, $task);
        $this->assertSame('', $task->getId());
        $this->assertSame('', $task->getLabel());
        $this->assertSame('', $task->getDescription());
        $this->assertFalse($task->isDone());
        $this->assertInstanceOf(\DateTime::class, $task->getCreated());
        $this->assertInstanceOf(\DateTime::class, $task->getModified());
    }

    /**
     * Bad data provider returns values to feed to the unit test to check
     * input validation is done correctly
     *
     * @return array
     */
    public function badDataProvider()
    {
        return [
            [1234, 'This is a test task', 'This test validates the task entity', false],
            ['2340ee1c-499c-4c31-ac80-0da6f480a2bf', 1234, 'This test validates the task entity', true],
            ['2340ee1c-499c-4c31-ac80-0da6f480a2bf', 'This is a test task', 1234, false],
            ['2340ee1c-499c-4c31-ac80-0da6f480a2bf', 'This is a test task', 'This test validates the task entity', 'foo'],
        ];
    }

    /**
     * Test that an exception is thrown when wrong arguments are
     * being used to instantiate a new task entity.
     *
     * @covers TaskEntity::__construct
     * @dataProvider badDataProvider
     * @expectedException \InvalidArgumentException
     */
    public function testTaskEntityThrowsExceptionWhenConstructedWithWrongArguments(
        $id,
        $label,
        $description,
        $done
    )
    {
        $task = new TaskEntity($id, $label, $description, $done);
        $this->fail('Expected exception was not thrown');
    }
}