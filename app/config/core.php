<?php
/**
 * これは、コアとなる設定ファイルです。
 *
 * Cake のコアとなる振る舞いを設定するのに使ってください。
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * ファイルの再配布には上記の著作権表示が必須です。
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *--------
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * CakePHP デバッグレベル:
 *
 * 本番モード:
 * 	0: エラーメッセージ、警告を画面に出さない。メッセージのフラッシュで redirect する。
 *
 * 開発モード:
 * 	1: エラー、警告が表示される。モデルキャッシュはリフレッシュされる。メッセージのフラッシュで一時停止する。
 * 	2: 上記1に加え、デバッグメッセージとSQL出力を完全に行う。
 *
 * flash() を使う場合、
 * 本番モードではメッセージ表示して一定時間後にリダイレクトされますが、
 * 開発モードではメッセージ表示後にクリックして次に進むようになります。
 *--------
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug', 2);

/**
 * あなたのアプリケーションでエラーをハンドルするのに使うエラーハンドラを設定してください。
 * デフォルトでは、ErrorHandler::handleError() が使われます。その場合、
 * debug > 0 なら、エラーは Debugger を使って出力されます。
 * debug = 0 なら、エラーは CakeLog を使ってログ出力されます。
 *
 * オプション:
 *
 * - `handler` - callback - エラーをハンドルするコールバック。呼び出し可能なタイプは何でも（無名関数でも）セットできる。
 * - `level`   - int      - 捕捉したいエラーのレベル。
 * - `trace`   - boolean  - ログファイルにエラーのスタックトレースを含めるか。
 *
 * @see ErrorHandler - エラーのハンドルや設定の詳細はこのクラスを参照してください。
 *--------
 * Configure the Error handler used to handle errors for your application.  By default
 * ErrorHandler::handleError() is used.  It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
 *    including anonymous functions.
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level'   => E_ALL & ~E_DEPRECATED,
		'trace'   => true
	));

/**
 * catch されなかった例外のための、例外ハンドラを設定してください。
 * デフォルトでは、ErrorHandler::handleException() が使われます。その場合、その例外用の HTML ページが表示され、
 * debug > 0 なら、Missing Controller のようなフレームワークのエラーが表示されます。
 * debug = 0 なら、フレームワークのエラーは強制的に汎用的な HTTP エラーとして表示されます。
 *
 * オプション:
 *
 * - `handler`  - callback - エラーをハンドルするコールバック。呼び出し可能なタイプは何でも（無名関数でも）セットできる。
 * - `renderer` - string   - catch されなかった例外を描画(render)する担当のクラス。
 *      独自のクラスを指定するなら、そのクラスのファイルを app/Lib/Error の下に置くこと。
 *      このクラスは render メソッドを実装していなければなりません。
 * - `log`      - boolean  - 例外をログに出力するか。
 *
 * @see ErrorHandler - 例外のハンドルや設定の詳細はこのクラスを参照してください。
 *--------
 * Configure the Exception handler used for uncaught exceptions.  By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed.  When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 * - `renderer` - string - The class responsible for rendering uncaught exceptions.  If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
	Configure::write('Exception', array(
		'handler'  => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log'      => true
	));

/**
 * アプリケーション全体の charset エンコーディング。
 *--------
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * CakePHP が mod_rewrite を【使わずに】、CakePHP 的な URL を使いたいのであれば、下記の .htaccess を削除し、
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * 下記の、App.baseUrl についてのコメントアウトを解除してください。
 *--------
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * CakePHP の接頭辞ルート機能を使うなら、以下の定義のコメントアウトを解除してください。
 *
 * ここで定義した値により、ルートの名前が決まり、関連するコントローラのアクションが決まります。
 *
 * あなたのアプリケーションで使う接頭辞を配列で指定してください。admin や、その他、接頭辞が必要なルート用に使ってください。
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * 上記のように設定した場合、下記のような URL になります。
 *	`admin_index()`   なら `/admin/controller名/index`
 *	`manager_index()` なら `/manager/controller名/index`
 *--------
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 *	`admin_index()` and `/admin/controller/index`
 *	`manager_index()` and `/manager/controller/index`
 *
 */
	//Configure::write('Routing.prefixes', array('admin'));

/**
 * アプリケーション全体でキャッシュ機能をオフにしたいなら、コメントアウトを解除してください。
 *--------
 * Turn off all caching application-wide.
 */
	//Configure::write('Cache.disable', true);

/**
 * キャッシュ・チェック機能を有効にする。
 *
 * true にセットした場合、ビューのキャッシュを使うためには、
 * あなたのコントローラ内にある public $cacheAction 
 * （キャッシュの設定を定義するもの）も使わなければなりません。
 * あるコントローラ全体で有効にするためにコントローラの public $cacheAction = true を設定してもよいですし、
 * 個々のアクションで $this->cacheAction = true と設定してもかまいません。
 *--------
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 */
	//Configure::write('Cache.check', true);

/**
 * log() 関数を使う場合の、デフォルトのエラータイプを定義してください。
 * ログ出力と、デバッグの判別に使われます。今のところ PHP は LOG_DEBUG をサポートしています。
 *--------
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', LOG_ERR);

/**
 * セッションの設定。
 *
 * セッションの設定に使用する配列の設定値を定義してください。
 * Session.defaults のキーは、セッションを使う際の、デフォルトのプリセット(初期設定群)を選ぶのに使い、
 * なんらかの設定を宣言した際には、このデフォルト値を上書くことになります。
 *
 * ## オプション
 *
 * - `Session.cookie`        - 使用する Cookie の名前。デフォルトは 'CAKEPHP'
 * - `Session.timeout`       - セッションの生存期間（分）。このタイムアウトは CakePHP によってハンドルされる。
 * - `Session.cookieTimeout` - セッション Cookie の生存期間（分）。
 * - `Session.checkAgent`    - セッション開始時に user agent をチェックするか。
 *              昔のIEや、Chromeのフレーム、Webブラウザを持つ装置とAJAX などを扱う必要がある場合に、
 *              false に設定したいということがありえる。
 * - `Session.defaults`      - あなたのセッションのベースとして使うデフォルトの設定。
 *              ４つの組み込み値が存在する。: php, cake, cache, database.
 * - `Session.handler`       - カスタムのセッションハンドラを有効にするために使うことができる。
 *              呼び出し可能なものを配列で指定し、それは `session_save_handler` とともに使われる。
 *              このオプションを使うと、自動的に `session.save_handler` が ini 配列に追加される。
 * - `Session.autoRegenerate` - この設定を有効にすると、セッションの自動更新がＯＮになり、
 *              セッションIDが頻繁に変更されることになる。CakeSession::$requestCountdown 参照。
 * - `Session.ini`           - 追加でセットしたい ini 値の連想配列。
 *
 * Session.defaults の組み込みの値:
 *
 * - 'php'      - あなたの php.ini で定義されている設定値を使う。
 * - 'cake'     - CakePHP の /tmp ディレクトリにセッションファイルを保存する。
 * - 'database' - CakePHP のデータベースセッションを使う。
 * - 'cache'    - セッションの保存に Cache クラスを使う。
 *
 * カスタムのセッションハンドラを定義する場合は、その定義ファイルを /app/Model/Datasource/Session/<name>.php に保存してください。
 * 必ず `CakeSessionHandlerInterface` をそのクラスに実装し、Session.handler に <name> をセットしてください。
 *
 * データベースセッションを使うためには、cake のシェルコマンド【cake schema create Sessions】を使って、
 * app/Config/Schema/sessions.php スキーマを走らせてください。
 *--------
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler.  Expects an array of of callables,
 *    that can be used with `session_save_handler`.  Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
	Configure::write('Session', array(
		'defaults' => 'php'
	));

/**
 * CakePHP のセキュリティのレベル。
 *--------
 * The level of CakePHP security.
 */
	Configure::write('Security.level', 'medium');

/**
 * セキュリティのハッシュ生成に用いられるランダム文字列。
 *--------
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');

/**
 * 文字列を encrypt/decrypt する際に使う、ランダムな数値（数値のみ）の文字列。
 *--------
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '76859309657453542496749683645');

/**
 * static な資産ファイル（js, css, images）に対して、最終更新日時のタイムスタンプを使うようにします。
 * こうすることで、querystring パラメータにファイルの更新日時が追加されることになります。
 * これはブラウザのキャッシュを無効にするのに便利な方法です。
 *
 * debug > 0 の場合にタイムスタンプを適用するなら true を指定してください。
 * debug に関係なく常にタイムスタンプを適用するなら、'force' を指定してください。
 *--------
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
	//Configure::write('Asset.timestamp', true);

/**
 * CSS の出力で、コメント、空白、連続するタブなどを撤去することで圧縮します。
 * これは a/var/cache ディレクトリが Web サーバからキャッシュ用に書き込むことが可能であることと、
 * /vendors/csspp/csspp.php が必要です。
 *
 * 使用の際には、CSS へリンクする URL の頭に '/css/' ではなく '/ccss/' を付けるか、HtmlHelper::css() を使ってください。
 *--------
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * 独自の JavaScript 圧縮ロジック（出力をハンドルするために webroot にスクリプトを配置するロジック）をプラグインとしてセットします。
 * 下記のようにこのスクリプトの名前を指定してください。
 * 
 * 使用の際には、JavaScript へリンクする URL の頭に '/js/' ではなく '/cjs/' を付けるか、JavaScriptHelper::link() を使ってください。
 *--------
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * CakePHP の ACL (アクセス・コントロール・リスト) 機能で使う、クラス名とデータベース。
 *--------
 * The classname and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

/**
 * この行のコメントアウトを解除し、あなたのサーバのタイムゾーンに修正してください。
 * エラーに関連する日時が正しくなります。
 *--------
 * Uncomment this line and correct your server timezone to fix
 * any date & time related errors.
 */
	//date_default_timezone_set('UTC');

/**
 * 使用するキャッシュエンジンを指定します。APC が有効なら、それを使ってください。
 * CLI を介して実行しているなら、APC はデフォルトでは無効です。
 * それがこの場合で利用可能であり、有効になっているのか確認してください。
 *
 * 注： 'default' および、そのほかのアプリケーションキャッシュは app/Config/bootstrap.php の中で設定されていなければなりません。
 *      利用可能なキャッシュエンジンについては boostrap.php 内のコメントと、その設定値をチェックしてください。
 *--------
 * Pick the caching engine to use.  If APC is enabled use it.
 * If running via cli - apc is disabled by default. ensure it's available and enabled in this case
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in boostrap.php for more info on the cache engines available
 *       and their setttings.
 */
$engine = 'File';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}

// 開発モードなら、キャッシュはすぐに期限切れとなります。
// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
	$duration = '+10 seconds';
}

// Memcache と APC とで衝突しないように、同じサーバで動く各アプリケーションに異なる接頭辞を付けます。
// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'myapp_';

/**
 * 一般的なフレームワークのキャッシュ用に使われるキャッシュの設定です。
 * path 情報、オブジェクト・リスティング、翻訳キャッシュファイルはこの設定を使って保存されます。
 *--------
 * Configure the cache used for general framework caching.  Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine'    => $engine,
	'prefix'    => $prefix . 'cake_core_',
	'path'      => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration'  => $duration
));

/**
 * モデルとデータベースのキャッシュの設定です。
 * このキャッシュ設定はコネクション内のスキーマ記述とテーブル・リスティングを保存するのに使います。
 *--------
 * Configure the cache for model and datasource caches.  This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine'    => $engine,
	'prefix'    => $prefix . 'cake_model_',
	'path'      => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration'  => $duration
));