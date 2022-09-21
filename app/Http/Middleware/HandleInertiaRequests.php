<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                $authUser = $request->user();
                if ($authUser) {
                    return [
                        'user' => $authUser->only('id', 'name', 'email', 'role'),
                        'notifiCount' => $authUser->unreadNotifications->count(),
                        'returnAdmin' => session()->has('exit_admin_id'),
                    ];
                }
            },
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'flash' => function () use ($request) {
                return [
                    'newFlash' => $request->session()->get('newFlash'),
                    'type' => $request->session()->get('type'),
                    'massage' => $request->session()->get('massage')
                ];
            },
        ]);
    }
}
