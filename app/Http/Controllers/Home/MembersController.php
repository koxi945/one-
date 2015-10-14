<?php namespace App\Http\Controllers\Home;

use App\Services\OAuth\SC;
use Request;

/**
 * 用户相关的，包括注册，登陆。
 *
 * @author jiang <mylampblog@163.com>
 */
class MembersController extends Controller
{
    /**
     * oauth client provider
     * 
     * @var object
     */
    private $provider;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'      => config('oauth.clientId'),
            'clientSecret'  => config('oauth.clientSecret'),
            'redirectUri'   => config('oauth.redirectUri'),
            'urlAuthorize'  => config('oauth.urlAuthorize'),
            'urlAccessToken'  => config('oauth.urlAccessToken'),
            'urlResourceOwnerDetails'  => config('oauth.urlResourceOwnerDetails'),
        ]);
    }

    /**
     * 用户的页面
     * @return [type] [description]
     */
    public function login()
    {
        $authUrl = $this->provider->getAuthorizationUrl();
        //dd($authUrl);
        SC::setOauthStat($this->provider->getState());
        return redirect($authUrl);
    }

    /**
     * 登陆的回调地址
     */
    public function loginback()
    {
        $error = Request::input('error');
        $state = Request::input('state');
        $code = Request::input('code');

        if( ! empty($error)) {
            return view('home.login.denied', compact('error'));
        }

        if(empty($code) or empty($state) or $state != SC::getOauthStat()) {
            SC::delOauthStat();
            $error = 'Invalid state';
            return view('home.login.denied', compact('error'));
        }

        $accessToken = $this->provider->getAccessToken('authorization_code', [
            'code' => $code
        ]);

        echo $accessToken->getToken() . "<br/>";
        echo $accessToken->getRefreshToken() . "<br/>";
        echo $accessToken->getExpires() . "<br/>";
        echo ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br/>";

        $resourceOwner = $this->provider->getResourceOwner($accessToken);
        var_export($resourceOwner->toArray());

        /*$request = $this->provider->getAuthenticatedRequest(
            'GET',
            'http://brentertainment.com/oauth2/lockdin/resource',
            $accessToken
        );*/


    }

}