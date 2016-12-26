<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATrgb
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */


function env($key, $default)
{
	$value = getenv($key);

	$value = $value ? $value : $default;

	return $value;
}

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', env('MYSQL_ENV_MYSQL_DATABASE', 'chinargb'));

/** MySQL数据库用户名 */
define('DB_USER', env('MYSQL_ENV_MYSQL_USER', 'root'));

/** MySQL数据库密码 */
define('DB_PASSWORD', env('MYSQL_ENV_MYSQL_PASSWORD', 'r00t'));

/** MySQL主机 */
define('DB_HOST', env('MYSQL_PORT_3306_TCP_ADDR', '127.0.0.1'));

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*7=PP69#?w~*kA]a(tA-9z`KTTTsZC&>N;apjmjb`$d_h5iXHAhu??kee6leO0|k');
define('SECURE_AUTH_KEY',  'ghwoX~D< huc?jE1qBu[7 RfMYKQE;n}z!Bmm}GxJJ/vfh}*S,Az(OR5qJ7`QKT$');
define('LOGGED_IN_KEY',    'mYB*W+F*S^`3UE+ MS^W&p=&v/pD?F]^%!2)xj}J2B=8F?!gNmcC-]M#U>1N4Qa:');
define('NONCE_KEY',        '~]SN$+Jr(?ExI|G6+ZEP7H>=3{^OgZA}@$9E73}l{G0a(29>?orv$xS+4CFmg1(9');
define('AUTH_SALT',        ' |cGPx**[#>OVgctz%;qP)/VGrvNrA2`pGq:CcI1`weT/R$c:nrs*Y8x,{|m3Ks[');
define('SECURE_AUTH_SALT', 'jZ%{0]@X6>&9HrPM+IY[9c]b7?;#Zc=Ak3mhnS.jB1h6{t;]t&SK^:S9oxnWJC[N');
define('LOGGED_IN_SALT',   '8~~&tChp/}vncl!sctmkENm8F|mb6X!6WRlAKt[*fAQm.:^7xy}*/gzJx08SHjPp');
define('NONCE_SALT',       'Qfc<ZE{Q&EXfhlzRbpz@bU(a$.*fR#&^IlK2Mq7yZx3V]}?m+#tk&PAlWKki.d E');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
