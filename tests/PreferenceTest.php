<?php

class PreferenceTest extends TestCase
{
    public function testSinglePreferenceByName()
    {
        $user = factory(User::class)->create();

        $user->setPreference('color', '#beeeef');

        $this->assertSame('#beeeef', $user->getPreference('color'));
    }

    public function testSinglePreferenceByInstance()
    {
        $user = factory(User::class)->create();

        $user->setPreference($preference, '#beeeef');

        $this->assertSame('#beeeef', $user->getPreference($preference));
    }

    public function testSetAndGetAllPreferences()
    {
        $preferences = [
            'color' => 'blue',
            'font-size' => '19px',
            'anonymous' => true,
        ];

        $user = factory(User::class)->create();

        $user->setPreferences($preferences);

        $this->assertSame($preferences, $user->getPreferences());
    }

    public function testGetSomePreferences()
    {
        $preferences = [
            'color' => 'blue',
            'font-size' => '19px',
            'anonymous' => true,
        ];

        $user = factory(User::class)->create();

        $user->setPreferences($preferences);

        $this->assertSame([
            'color' => 'blue',
            'font-size' => '19px',
        ], $user->getPreferences('color', 'font-size');
    }

    public function testGetPreferenceWithBoolCasting()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'anonymous',
                'cast' => 'bool',
            ]);

        $user = factory(User::class)->create();

        $user->setPreference('anonymous', true);

        $this->assertSame(true, $user->getPreference('anonymous'));
    }

    public function testGetPreferenceWithIntCasting()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'age',
                'cast' => 'int',
            ]);

        $user = factory(User::class)->create();

        $user->setPreference('age', 25);

        $this->assertSame(25, $user->getPreference('age'));
    }

    public function testGetPreferenceWithFloatCasting()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'age',
                'cast' => 'float',
            ]);

        $user = factory(User::class)->create();

        $user->setPreference('age', 25.53);

        $this->assertTrue(is_float($user->getPreference('age')));
    }

    public function testGetPreferenceWithStringCasting()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'age',
                'cast' => 'string',
            ]);

        $user = factory(User::class)->create();

        $user->setPreference('age', 25.53);

        $this->assertSame('25.53', $user->getPreference('age'));
    }

    public function testGetPreferencesWithCasting()
    {
        $preferences = [
            'age' => 25,
            'number' => '7',
            'anonymous' => true,
        ];

        factory(Preference::class)->create([
            'name' => 'age',
            'cast' => 'int',
        ]);

        factory(Preference::class)->create([
            'name' => 'number',
            'cast' => 'string',
        ]);

        factory(Preference::class)->create([
            'name' => 'anonymous',
            'cast' => 'bool',
        ]);

        $user = factory(User::class)->create();

        $user->setPreferences($preferences);

        $this->assertSame($preferences, $user->getPreferences());
    }

    public function testDefault()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'age',
                'default' => '18',
            ]);

        $user = factory(User::class)->create();

        $this->assertSame('18', $user->getPreference('age'));
    }

    public function testNoDefault()
    {
        $preference = factory(Preference::class)
            ->create(['name' => 'age']);

        $user = factory(User::class)->create();

        $this->assertNull($user->getPreference('age'));
    }

    public function testNoDefaultWithCast()
    {
        $preference = factory(Preference::class)
            ->create([
                'name' => 'age',
                'cast' => 'string',
            ]);

        $user = factory(User::class)->create();

        $this->assertNull($user->getPreference('age'));
    }
}
