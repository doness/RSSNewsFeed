<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty get_category modifier plugin
 *
 * Type: modifier<br>
 * Name: get_category<br>
 * Purpose:strip html tags from text
 * @link http://smarty.php.net/manual/en/language.modifier.strip.tags.php
 *get_category (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param boolean
 * @return string
 */
function smarty_modifier_weather_icon($weather_code) {
$icons = array(
0 => "tornado",
1 => "tropical storm",
2 => "hurricane",
3 => "severe thunderstorms",
4 => "thunderstorms",
5 => "mixed rain and snow",
6 => "mixed rain and sleet",
7 => "mixed snow and sleet",
8 => "freezing drizzle",
9 => "drizzle",
10 => "freezing rain",
11 => "showers",
12 => "showers",
13 => "snow flurries",
14 => "light snow showers",
15 => "blowing snow",
16 => "snow",
17 => "hail",
18 => "sleet",
19 => "dust",
20 => "foggy",
21 => "haze",
22 => "smoky",
23 => "blustery",
24 => "windy",
25 => "cold",
26 => "cloudy",
27 => "mostly cloudy (night)",
28 => "mostly cloudy (day)",
29 => "partly cloudy (night)",
30 => "partly cloudy (day)",
31 => "<ul><li class='icon-moon'></li></ul>",
32 => "<ul><li class='icon-sun'></li></ul>",
33 => "<ul><li class='icon-moon'></li></ul>",
34 => "<ul><li class='icon-sun'></li></ul>",
35 => "mixed rain and hail",
36 => "hot",
37 => "isolated thunderstorms",
38 => "scattered thunderstorms",
39 => "scattered thunderstorms",
40 => "scattered showers",
41 => "heavy snow",
42 => "scattered snow showers",
43 => "heavy snow",
44 => "partly cloudy",
45 => "thundershowers",
46 => "snow showers",
47 => "isolated thundershowers",
3200 => "not available"
);
return $icons["$weather_code"];
}
/* vim: set expandtab: */

?>
