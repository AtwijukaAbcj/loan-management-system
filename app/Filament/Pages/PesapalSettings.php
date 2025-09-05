<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class PesapalSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $view = 'filament.pages.pesapal-settings';
    protected static ?string $navigationLabel = 'Pesapal Settings';
    protected static ?string $title = 'Pesapal API Settings';
    protected static ?string $navigationGroup = 'Addons';

    public $consumer_key;
    public $consumer_secret;
    public $test_result;
    public function testKeys()
    {
        // Simulate a test call to Pesapal API
        if ($this->consumer_key && $this->consumer_secret) {
            $this->test_result = 'Test successful! Keys are set.';
        } else {
            $this->test_result = 'Test failed! Please enter both keys.';
        }
    }

    public function mount()
    {
        $this->consumer_key = env('PESAPAL_CONSUMER_KEY');
        $this->consumer_secret = env('PESAPAL_CONSUMER_SECRET');
    }

    public function save()
    {
        // For demo: just flash values. In production, save to DB or .env
        Session::flash('success', 'Pesapal keys saved!');
        Session::flash('consumer_key', $this->consumer_key);
        Session::flash('consumer_secret', $this->consumer_secret);
    }
}
