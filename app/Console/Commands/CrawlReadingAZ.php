<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\String_;
use voku\helper\HtmlDomParser;

class CrawlReadingAZ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:raz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $cookie = [];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $levels = ['aa','z1','z2'];
//        foreach ($levels as $level){
//            $this->mkdir($level);
//        }
//        for($i=97;$i<97+26;$i++){
//            $this->mkdir(chr($i));
//        }
        parent::__construct();
    }

    private function mkdir($level){

        $path = "ReadingAZ/Slider/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/SingleSidedBook/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/DoubleSidedBook/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/Pocketbook/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/ReadAndColorBooks/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/WritingResources/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/LessonResources/$level";
        Storage::makeDirectory($path);

        $path = "ReadingAZ/Worksheets/$level";
        Storage::makeDirectory($path);
    }

    public function meta() {
        $jsonPath = "ReadingAZ/raz.json";
        $fn = fopen(storage_path($jsonPath),"r");

        $newArrays = [];
        while(! feof($fn))  {
            $result = fgets($fn);
//            echo $result;
            $array = explode(';',$result);
            $keys  = ['level','id','type','title'];
            foreach ($array as $key=>$value){
                $ws = " \t\n\r\0\x0B\u200b";
//                $value = preg_replace("/\\u200b/",'', $value);
                $value = trim($value,$ws);

//                if($key === 0 ){
//                    $value = strtoupper($value);
//                }
                $newArray[$keys[$key]] = $value;
            }
            $newArrays[] = $newArray;
//            break;
        }
//        Storage::put($jsonPath, json_encode($newArrays));
        dd(json_encode($newArrays));
        fclose($fn);
        return 0;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

//        $this->meta();
//        return 0;

//        $cookieStr = $this->ask('copy your cookies here');
//        $cookiesArray = explode(';', $cookieStr);
//        $cookies = [];
//        foreach ($cookiesArray as $cookie){
//            $cookieArray = explode('=', $cookie);
//            $cookies[trim($cookieArray[0])] = $cookieArray[1];
//        }

        $jsonPath = "ReadingAZ/pages.json";
        if(!Storage::exists($jsonPath)){
            Storage::put($jsonPath, "{}");
        }
        try {
        // $('.categoryList li').each(function(){
        // console.log(
        //  $(this).find('.title').text(), //title
        //  $(this).find('.title').next().text()) //Fiction1884
        // })
        // https://www.readinga-z.com/books/leveled-books/book/?id=2917&langId=1
        $bookIdStrings = '2917;1531;2724;174;2564;2660;2328;1641;3538;2338;2469;2383;168;834;1444;1932;1621;1059;175;647;1913;1030;170;2888;2330;178;934;1427;3831;173;1838;3862;3562;3861;2613;3050;3108;177;2727;1806;2964;1827;3670;1948;1977;2116;2157;2169;2189;2190;2194;2195;2203;2333;2334;1434;2466;171;3709;1527;2329;169;804;1586;167;2438;2231;1437;900;2410;3863;2331;3601;2230;2327;939;1735;878;3168;176;3143;1037;1653;1934;3968;2337;2336;1742;1401;1625;172;2625;1541;869;2803;2661;166;2332;3654;1164;2802;9;1914;1824;1717;13;2969;1891;1406;1387;3369;2785;3158;4050;2384;3147;1543;1513;2121;28;2721;25;2899;3355;3721;1558;17;2259;815;6;2615;1757;3256;1930;2407;4039;1388;1635;1622;8;3823;3703;2518;30;29;888;3729;2463;27;7;2731;26;12;1863;2559;11;2284;2473;2619;1097;3566;1949;1067;1579;1599;2436;3926;1704;3365;2883;2173;2895;911;2519;1644;3107;2988;1569;2439;3931;3534;2406;3415;2941;3482;879;653;789;2749;910;826;2650;3086;3310;2216;3394;2111;2879;3058;3309;1306;1022;1976;785;781;1530;3269;2520;852;2790;1880;2753;2254;2325;1399;2387;2164;3707;3488;2290;3884;15;16;3421;1446;2944;3116;2789;2904;31;1812;1309;1828;1590;810;20;835;23;2521;2722;1718;3725;949;2665;3537;2626;2470;33;1623;2446;2965;18;1842;21;2475;22;14;34;1664;2728;3584;2918;2555;2692;1950;1060;1743;3082;1570;2411;2989;1851;2440;1589;3344;2620;3717;3360;19;1202;3407;2237;3164;245;1215;1174;1340;32;24;3856;1147;825;889;2014;3425;3712;2161;1981;1881;1357;43;3596;2418;2791;45;3578;3824;2607;293;2525;1642;1761;3832;42;2010;2522;40;2960;320;1216;61;1521;44;60;1175;853;3550;1405;1441;3399;1393;2729;1330;1786;3965;901;2339;1702;2249;1565;2897;2277;2414;3136;3901;1862;2896;249;1935;3374;1830;3483;3004;786;3252;1595;2567;1553;3046;2725;3335;2392;1571;2158;3072;1308;2516;3657;41;2627;2291;3957;2765;928;2526;237;3316;319;2448;2804;1134;3888;1525;46;2478;1867;1736;318;2471;38;2180;791;62;2655;2467;2441;2326;1539;2952;1843;1816;1854;2621;2260;2474;2920;2757;951;56;53;49;1076;2970;1820;3547;1535;2730;950;2419;51;1762;2513;1203;1870;3417;912;3398;2844;1447;862;2831;2792;2694;2214;2514;2690;1217;1461;827;854;1807;2614;1155;2919;1522;1381;1690;1438;3260;3112;925;3370;2884;54;2449;2166;1562;48;3967;1892;1654;2723;1719;52;3908;2523;57;47;3042;2385;1630;3897;1454;2805;1018;3604;55;50;59;660;3487;1567;2288;58;2900;2942;1633;73;2453;1232;2479;1896;2691;662;67;1978;3262;1877;2736;1414;254;69;3078;3340;903;995;2761;1832;65;2732;2292;2388;3160;74;72;3475;1649;929;1572;2472;2608;63;2836;2150;2413;1230;1017;2524;3364;3416;2117;1464;2651;2437;880;1585;926;2846;2184;71;959;2616;2412;2832;937;972;973;2972;2881;1915;1738;68;1564;66;2006;1348;2565;2241;3857;2250;64;927;902;1689;70;2695;2898;2993;3737;3738;2293;2799;1656;2880;2416;2693;2845;2921;4123;2618;1276;3530;89;1936;94;2527;836;1098;1924;2155;2971;797;1236;90;2617;1825;3868;1866;253;2464;1176;816;2649;96;3314;233;271;91;252;985;2882;2560;996;1591;316;3579;2830;2943;663;1184;92;2726;95;1620;2468;97;1822;268;2255;3090;3159;2916;856;2786;2912;2167;1542;984;2011;2219;3854;2834;2393;1720;1165;1554;1293;1878;871;2442;1695;1419;2450;98;3123;93;2787;3970;3790;1833;2465;1951;86;85;2264;289;2835;1287;803;270;2417;1643;1840;1394;83;1868;2340;4171;1856;77;1518;2232;4122;3051;87;1566;1396;2976;2609;3348;79;2420;80;1699;1722;2335;269;1536;2515;78;2566;1658;88;2905;2737;267;837;2656;81;2187;1573;3318;3403;3032;1850;1634;75;2628;1451;1808;2245;1557;1547;2955;3577;82;665;1853;2833;1819;2289;2568;2447;2788;1395;1937;2738;1556;1900;2386;1587;84;2108;2122;3925;3869;2652;2500;102;1456;1370;1723;3826;2146;2793;1691;1449;1931;1417;2990;2517;262;2137;263;1523;1416;1879;3165;231;2134;3047;3395;3519;101;1946;1369;2892;1204;1660;3249;3595;106;1809;3479;1392;103;2622;1341;108;805;2221;4167;264;266;1561;2933;3865;3668;1148;2556;1365;3890;100;2913;1382;1864;1756;2977;1636;646;2220;3352;99;2491;787;1901;1821;3567;107;945;1135;104;3886;2261;1744;890;2766;3705;1241;3543;779;1952;3079;3659;1242;4055;2494;1813;119;2841;272;1349;1043;117;265;113;2750;3605;115;3898;2265;3962;636;110;1318;1831;1292;1291;2589;116;2215;1234;118;2595;114;3828;1038;120;3927;1646;2739;2131;3569;3039;112;1893;2238;2531;3319;1068;974;1021;898;967;1088;273;2170;2935;2931;2932;2934;2936;1857;3713;1792;1874;3666;3875;1897;1829;109;3109;4044;1205;881;1700;2574;1212;1459;2125;792;3422;2901;1156;3883;3332;3361;3789;740;3023;2497;1031;274;294;1153;1991;1645;738;3020;251;809;1845;2598;4172;186;2480;916;1244;3669;2000;2662;1430;742;870;648;2140;2143;1737;1077;3602;1534;2015;3853;3349;1624;1758;3667;2443;1455;2592;3489;743;295;3726;1982;1692;241;2256;2930;1708;1331;741;2128;2569;2945;2421;1945;1652;3266;3104;633;1580;1335;1726;1510;2838;960;961;2754;2885;1082;1947;1385;975;1445;1655;1023;2109;1887;2123;739;3660;2653;179;1233;650;1312;1724;2794;2783;1410;1593;2991;2012;1696;2229;2631;3932;3166;2577;3048;185;278;3396;275;2003;1337;1721;672;2893;1661;3250;1273;184;1371;3480;1277;1528;1231;1574;1997;708;2956;3087;1985;4121;2623;806;3972;3958;676;940;2222;630;180;2217;2185;2557;1969;3540;705;2978;183;3017;3727;1637;1284;744;3353;182;1916;2151;3885;3029;3011;706;181;1238;1703;277;279;2262;1745;649;2767;1240;3544;754;3080;1457;4056;2319;749;1814;3735;2842;286;3899;2313;1994;2751;752;3285;751;3606;1039;1953;2629;2266;756;2303;3963;755;1626;2534;1207;1206;678;3279;677;1707;1398;3714;1218;941;1588;280;276;747;828;3928;1647;748;1575;2740;1988;3570;3040;2532;3320;1429;3026;2966;746;1409;3580;1858;1917;1452;2191;1875;3876;2224;753;917;817;745;3110;3661;4045;3270;750;2575;1550;3008;281;1693;3971;3423;2902;1166;1789;863;261;3362;3563;3043;260;227;3895;236;1793;1659;1846;285;3706;2481;259;2316;258;2663;1237;1016;1515;674;2322;1448;1235;3551;1938;2430;284;1358;1354;3350;1759;2444;257;1514;228;1442;3490;3291;997;288;1436;256;1739;2257;1709;2239;2162;2579;2570;1898;2946;3837;2422;3887;758;3267;3105;1336;255;986;1453;795;675;757;1511;229;2839;1208;3288;2755;2886;282;283;1925;3598;2110;2124;1973;1219;2654;1248;1811;1826;1443;1563;3974;1725;2795;193;2784;246;2992;2218;882;189;1576;710;1810;1697;2632;3167;2578;1342;3049;3801;1246;1220;3397;198;1338;1834;1885;2894;3276;1662;3251;1315;3481;1278;2957;3088;3804;2007;2624;1303;1583;190;1460;2223;197;194;2558;807;1865;3273;191;2979;187;1638;195;709;196;3354;3409;4125;1705;1032;1439;2850;2779;2306;711;3792;192;2433;1555;1289;2263;1746;2768;3161;3545;1255;783;3081;1954;1764;1597;2226;4057;1412;1313;127;129;1815;2843;2752;3607;2633;2630;1024;2267;1844;2847;3964;1627;2535;2113;1974;3371;3574;1632;3033;126;3929;1648;123;1397;2741;800;3571;3795;838;3041;2533;1426;1740;3321;848;125;3326;829;682;2967;1765;1859;1939;1418;1404;1061;1400;3732;1389;1876;3877;122;1062;1431;1581;962;3111;128;4046;130;3333;793;124;2576;3798;121;3001;2188;3424;2903;1367;1790;1078;983;891;1265;2581;1918;3363;3044;1250;1069;3404;683;626;2242;224;1847;632;976;1345;2482;1817;679;1245;2664;1319;3144;686;778;1210;1209;4175;2159;819;963;712;952;3351;1760;2445;1099;2909;818;627;1860;3491;226;625;1435;225;1167;2258;624;1710;2528;1157;2580;3860;2571;2947;2423;3268;3106;1894;693;3891;713;4040;1402;1366;1288;1177;1512;2840;2756;2887;1926;3329;1432;1407;2657;2583;2501;1048;1243;2742;2800;2801;1888;3535;205;200;1979;1883;698;716;201;2758;1252;1698;714;1137;696;3476;1247;717;203;694;839;1835;206;2144;1884;830;681;2227;3858;1855;1316;1274;3959;3864;4173;2958;3089;3137;2132;1869;2008;1136;864;1940;3055;199;1070;899;924;958;3608;2940;1450;232;1440;688;987;3711;2251;2871;2859;3575;1363;3075;715;202;1841;3410;2492;685;1063;2780;1239;3708;3918;2240;689;3400;1064;977;1149;4053;1849;3345;204;3162;3412;1279;2856;1254;1249;1955;163;1980;1259;2495;849;2147;999;1020;1028;2914;1035;2915;857;2634;2848;2135;1415;1433;1463;1390;1386;162;158;188;1970;1628;2536;1377;1384;2590;3484;3372;1350;3253;3034;2948;2596;156;700;883;3969;2874;4049;3327;2538;2939;2837;2937;1045;159;161;1047;919;2968;702;1355;1211;2225;165;3083;3961;1297;3391;2119;153;1532;1285;154;155;2246;164;3117;3532;160;3334;918;157;1181;3337;858;1290;2126;3000;1374;1368;1791;2582;3722;1004;3045;3024;4120;1314;2498;704;3870;3730;964;3405;1079;1042;3003;2826;3658;1552;820;3021;1044;2243;2138;2599;3966;2120;2004;1803;3145;764;2853;904;2141;2927;3357;766;718;2171;1294;3542;1998;935;3492;2868;2910;2593;1920;1280;1871;223;1071;222;3976;4015;762;763;1102;1029;2539;2938;2529;719;3257;2129;220;1304;3930;4170;1138;765;242;3728;1343;3120;3341;692;3663;637;1320;1359;1927;691;1150;221;3872;759;3330;2181;760;2658;812;139;1267;872;207;780;3903;1251;2743;794;1372;3924;2828;2827;1992;1889;906;892;137;2537;134;873;135;3715;2759;1346;697;132;1256;1861;3477;3366;140;290;1361;1986;3822;1919;3138;2009;138;4047;3056;1983;905;3849;1160;3549;3418;884;3610;2408;2961;3911;3912;3913;3263;2252;2152;635;2172;2192;2193;136;695;3076;238;3018;4041;2865;1012;4043;131;1324;3576;3411;3030;3012;943;3919;1848;3401;1025;1221;1322;1168;1942;3859;720;3346;3163;3413;3710;150;2585;1956;1258;148;3052;2320;2781;2314;1051;1995;3286;1253;2163;1408;143;4051;2001;2304;2849;3866;3802;1929;149;1836;1971;152;821;3280;1403;3485;3373;151;3254;3035;2236;2949;3833;790;1183;1378;144;1015;1084;1989;687;1049;3328;1650;859;141;1594;3027;147;3973;2114;1050;840;142;690;3084;145;841;3392;1694;1538;3889;2247;1052;3118;1551;3739;3271;2451;703;3323;3548;2016;3009;1545;2452;3338;1169;3002;1375;3603;3975;894;218;1072;234;3718;966;3406;723;1657;1516;214;2477;1852;2244;3825;3733;3656;1428;2317;721;831;2118;1933;1804;953;3146;1260;1629;1546;3609;2323;2928;3358;2431;2476;3600;213;2973;944;722;3493;3805;3565;2911;217;1921;1872;3539;216;3292;4038;2796;724;1085;3005;3900;701;291;3091;2530;822;3258;3834;3541;954;317;3914;1727;1139;4168;947;3121;3342;777;3564;3289;215;1582;1321;3793;1054;1360;3892;1975;3331;2182;1957;895;2659;920;1264;634;1266;2584;2671;4052;2013;3311;3904;727;1065;1373;1890;240;847;2760;2572;1741;209;3915;3906;211;1257;1158;3478;1747;3581;3277;3367;2168;699;801;1362;1014;3139;3796;726;3057;1262;1026;3905;3572;3419;631;814;1728;2228;3874;2962;212;4058;725;2573;1033;3274;210;3264;3113;3655;2253;2153;208;3077;3546;1598;3662;1325;2160;3719;2851;3723;2307;3920;948;3402;1526;3799;1882;2434;1323;1943;1002;3873;767;3347;3414;2857;146;4169;2456;2502;3025;3053;1577;1073;1993;3022;2389;2297;955;3731;876;2002;644;2017;1958;1972;1639;638;3486;1352;1520;3255;3073;2950;907;1763;788;2875;2133;2561;2806;2815;2816;2817;2818;2819;2820;2821;2822;2823;2824;2807;2825;2877;2878;2808;2809;2810;2811;2812;2813;2814;3568;1663;1941;1578;3536;1053;628;1081;729;1159;2130;1928;3867;2890;2860;3085;768;2285;1383;2866;1040;1549;3393;1548;3704;860;842;2493;2248;3119;1100;243;2426;3324;730;3702;3375;3339;2127;643;832;3740;3749;3750;3751;3741;3742;3743;3744;3745;3746;3747;3748;2115;732;1413;1533;3140;3094;3103;3095;3096;3097;3098;3099;3100;3101;3102;1895;844;733;2496;861;2483;2402;1839;1524;1823;2891;2139;1056;2136;2485;988;769;1805;1261;2854;2591;2142;2300;1788;2929;3359;2597;1296;2974;833;1999;3494;2394;2869;1990;1922;629;908;4174;1873;642;990;2797;1651;2610;1984;885;813;3006;3092;843;2673;2165;3259;1034;645;1701;2278;1299;3019;2156;1462;2489;641;3031;3122;3013;1837;3343;734;735;3716;3496;3505;3497;3498;3499;3500;3501;3502;3503;3504;846;3059;1055;1281;2183;1959;2283;808;2428;845;2733;2906;2994;3720;896;3312;3506;3871;2397;2997;2499;3907;823;2148;2669;3308;1996;2600;3573;1923;3531;1001;978;2005;2400;3376;2145;775;3368;782;2294;2666;4048;868;3734;4176;1987;2594;1013;3827;956;979;1263;3028;3420;2587;3611;737;3408;2409;2963;1356;3265;3114;1101;2458;2872;2953;2954;3916;2154;1364;4124;292;2280;2186;1899;772;1640;1027;1058;4063;4201;3010;770;1057;771;1944;1170;2112;2762;1344;2282;2429;3141;2734;2907;2995;2586;2309;728;2672;3313;3507;2398;2998;2637;1041;3054;2321;2782;1568;3356;865;3322;2311;2315;3287;2390;2298;3835;2305;2318;1584;3803;2454;773;2424;2301;3278;2324;3281;3074;2432;2975;2295;2667;2395;3806;2562;3797;3293;2798;2611;4042;2487;3007;3093;1152;2674;2404;3275;3115;1151;2459;3583;2286;2635;776;1559;2852;2460;2308;3272;3850;3851;3852;3290;731;3325;3800;3794;3060;2435;2675;2676;2677;2678;2679;2680;2681;2682;2683;2684;2685;2686;2687;2688;2689;2763;774;1592;3427;3428;3429;2858;3142;2735;2908;2996;2310;2457;3736;3508;2399;2999;3495;2638;2484;3597;2403;2670;2769;2770;2771;2772;2773;2774;2775;2776;2777;2778;2312;2503;2504;2505;2506;2507;2508;2509;2510;2511;2512;2391;2299;3582;2486;2455;2401;2855;2425;2302;2296;2668;3917;3336;2396;2870;2876;2563;2612;2488;2588;3612;3317;2980;2405;3665;2279;1631;2873;2861;2959;3261;3896;3294;3295;3296;3297;3298;3299;3300;3301;3302;3303;3304;3305;3306;3307;2287;2867;2636;2281;2490;3533;2461;2427;3061;2764';
        $bookIds = explode(';', $bookIdStrings);
        $count = 0;
        foreach ($bookIds as $bookId){
            Log::info("BookId: {$bookId} Count: " . ++$count);
            $json = json_decode(Storage::get($jsonPath),1);

            $url = "https://www.readinga-z.com/books/leveled-books/book/?id=$bookId&langId=1";
            $response = Http::get($url);
            $dom = HtmlDomParser::str_get_html($response->body());
            $title = trim($dom->findOne('h1.lang-english')->text());
//            $subtle = trim($dom->findOne('p.subtle')->text());
//            $description = $dom->find('#bookDetails p',1)->innerText();
            $count = $dom->find('#miniBookSlider img')->count();

            $level = strtolower(trim($dom->find('#levelBarNew a.active',0)->text()));

            // download miniBookSlider
            //todo Storage::makeDirectory in public folder : https://stackoverflow.com/questions/42624989/storagemakedirectory-in-public-folder
            $path = "ReadingAZ/Slider/$level/$bookId";
            Storage::makeDirectory($path);

            // miniBookSlider image
            $pages = [];
            foreach ($dom->find('#miniBookSlider img') as $i => $img){
                $pages[] = $img->getAttribute('src');
//                $filePath = "$path/page-$i.jpg";
//                if(!Storage::exists($filePath)){
//                    try {
//                        Log::info("{$bookId}: downloading $i");
//                        Storage::put($filePath, file_get_contents($img->getAttribute('src')));
//                    }catch (\Exception $e){
//                        Log::warning("miniBookSlider Exception:  {$bookId}  $i $img->getAttribute('src') {$e->getMessage()}");
//                    }
//
//                }
            }
            $id = $bookId;
            $data = compact('id','title','count','pages');
            $json[$id] = $data;
            Storage::put($jsonPath, json_encode($json));
            Log::info("Finished Book: {$bookId}");
            continue;
//            Log::info("{$bookId}: {$pageCount} pages downloaded");

            $highFrequencyWords = trim($dom->find('#lesson-resources-content p',1)->innerText());
            $reviewWords = trim($dom->find('#lesson-resources-content p',2)->innerText());
            $comprehension = trim($dom->find('#lesson-resources-content p',5)->innerText());
            $awareness = trim($dom->find('#lesson-resources-content p',6)->innerText());
            $phonics = trim($dom->find('#lesson-resources-content p',7)->innerText());
            $grammar = trim($dom->find('#lesson-resources-content p',8)->innerText());
            $wordWork = trim($dom->find('#lesson-resources-content p',9)->innerText());


            $pdfString = $dom->find('.list-arrow.marginT a',2)->getAttribute('require-teacher-login') ; //Book Resources
            $pattern = '/\'(\S+)\'/'; // 匹配两个单引号中间内容。
            if(preg_match($pattern, $pdfString,$matchs)){
                $pdfUri = $matchs[1];
                $pdfArray = explode('/', $pdfUri);
                $pdfName = str_replace("_clr_ds.pdf",'', array_pop($pdfArray)) ;

                // Single-Sided Book

                $pdf = "https://cf.content.readinga-z.com/pdfs/levels/$level/{$pdfName}_clr.pdf";
                $filePath = "ReadingAZ/SingleSidedBook/$level/{$bookId}_clr.pdf";
                Log::info("Single-Sided Book: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                        Log::info("Single-Sided Book: {$bookId} Downloaded");
                    }catch (\Exception $e){
                        $url = "https://www.readinga-z.com/members/levels/$level/{$pdfName}_clr.pdf";
                        $response = Http::withCookies($this->cookie,'www.readinga-z.com')->sink(storage_path("app/$filePath"))->get($url);
                        if($response->status() !== 200 ){
                            Log::warning("No Single-Sided Book: {$bookId}  wget -O $filePath $pdf");
                        }
                    }
                }else{
                    Log::info("Single-Sided Book: {$bookId} exists");
                }

                // Double-Sided Book PDF
                $pdf = "https://cf.content.readinga-z.com/pdfs/levels/$level/{$pdfName}_clr_ds.pdf";
                $filePath = "ReadingAZ/DoubleSidedBook/$level/{$bookId}_clr_ds.pdf";
                Log::info("Double-Sided Book: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                        Log::info("Double-Sided Book: {$bookId} Downloaded");
                    }catch (\Exception $e){
                        // https://www.readinga-z.com/site_and_dist/levels/aa_ds/raz_laa27_big_clr_ds.pdf
                        $url = $dom->find('a.pdf',2)->getAttribute('require-teacher-login') ; //Book Resources
                        $url = str_replace('{pageAfterLogin: \'','',$url);
                        $url = str_replace('\'}','',$url);
                        $url = "https://www.readinga-z.com{$url}";
                        if($url){
                            Log::info("Double-Sided Book: {$bookId} Downloading with cookie: $url");
                            $response = Http::withCookies($cookies,'www.readinga-z.com')->sink(storage_path("app/$filePath"))->get($url);
                            if($response->status() !== 200 ){
                                Log::error("Double-Sided Book: {$bookId}  wget -O $filePath $pdf");
                            }
                        }
                    }
                }else{
                    Log::info("Double-Sided Book: {$bookId} exists");
                }

                // Fold Only Double-Sided BookPDF
                // Pocketbook PDF
                $pdf = "https://cf.content.readinga-z.com/pdfsite/pocket_books/$level/{$pdfName}_pb.pdf";
                $filePath = "ReadingAZ/Pocketbook/$level/{$bookId}_pb.pdf";
                Log::info("Pocketbook Book: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                        Log::info("Pocketbook Book: {$bookId} Downloaded");
                    }catch (\Exception $e){
                        Log::warning("Pocketbook Book: {$bookId}  wget -O $filePath $pdf");
                    }
                }

                // Read and Color Books : Single-Sided Book
                $pdf = "https://cf.content.readinga-z.com/pdfs/levels/{$level}/{$pdfName}.pdf";
                $filePath = "ReadingAZ/ReadAndColorBooks/$level/{$bookId}.pdf";
                Log::info("Read and Color Book: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                        Log::info("Read and Color Book: {$bookId} Downloaded");
                    }catch (\Exception $e){
                        Log::warning("Read and Color Book: {$bookId} wget -O $filePath $pdf");
                    }

                }

                // Writing Resources
                $pdfString = $dom->find('.list-arrow .inlineBlock.padR a.pdf',0)->getAttribute('require-teacher-login') ; //Book Resources
                if(preg_match($pattern, $pdfString,$matchs)){
                    $tmpArray= explode('/',$matchs[1]);
                    $pdf = "https://cf.content.readinga-z.com/pdfsite/wordless_books/{$level}/{$tmpArray[count($tmpArray)-1]}";
                    $filePath = "ReadingAZ/WritingResources/$level/{$bookId}.pdf";
                    Log::info("Writing Resources: {$bookId} Downloading");
                    if(!Storage::exists($filePath)){
                        try {
                            Storage::put($filePath, file_get_contents($pdf));
                            Log::info("Writing Resources: {$bookId} Downloaded");
                        }catch (\Exception $e){
                            Log::warning("Writing Resources: {$bookId}  wget -O $filePath $pdf");
                        }
                    }

                }
                // Lesson Resources
                $pdf = "https://cf.content.readinga-z.com/pdfsite/{$bookId}/{$pdfName}_lblp.pdf";
                $filePath = "ReadingAZ/LessonResources/$level/{$bookId}_lblp.pdf";
                Log::info("Lesson Resources: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                        Log::info("Lesson Resources: {$bookId} Downloaded");
                    }catch (\Exception $e){
                        $pdf = "https://cf.content.readinga-z.com/pdfsite/lesson_plans/{$level}/{$pdfName}_lp.pdf";
                        try {
                            Storage::put($filePath, file_get_contents($pdf));
                            Log::info("Lesson Resources: {$bookId} Downloaded by 2");
                        }catch (\Exception $e){
                            $pdf = "https://cf.content.readinga-z.com/pdfsite/{$bookId}/{$pdfName}_lp.pdf";
                            try {
                                Storage::put($filePath, file_get_contents($pdf));
                                Log::info("Lesson Resources: {$bookId} Downloaded by 3");
                            }catch (\Exception $e){
                                Log::warning("Lesson Resources: {$bookId} ");
                            }
                        }
                    }
                }

                // Teach the Objectives // All Worksheets
                $pdf = "https://cf.content.readinga-z.com/pdfsite/{$bookId}/{$pdfName}_wksh.pdf";
                $filePath = "ReadingAZ/Worksheets/$level/{$bookId}_wksh.pdf";
                Log::info("All Worksheets: {$bookId} Downloading");
                if(!Storage::exists($filePath)){
                    try {
                        Storage::put($filePath, file_get_contents($pdf));
                    }catch (\Exception $e){
                        $pdf = "https://cf.content.readinga-z.com/pdfsite/worksheets/$level/{$pdfName}_wksh.pdf";
                        try {
                            Storage::put($filePath, file_get_contents($pdf));
                            Log::info("All Worksheets: {$bookId} Downloaded");
                        }catch (\Exception $e){
                            $pdf = "https://cf.content.readinga-z.com/pdfs/worksheets/$level/{$pdfName}_wksh.pdf";
                            try {
                                Storage::put($filePath, file_get_contents($pdf));
                                Log::info("All Worksheets: {$bookId} Downloaded by 2");
                            }catch (\Exception $e){
                                Log::warning("All Worksheets: {$bookId} {$e->getMessage()}");
                            }
                        }
                    }
                }

                $data = compact('bookId','level','title','subtle','description','pageCount',
                    'highFrequencyWords','reviewWords','comprehension','awareness','phonics','grammar','wordWork','pdfName');
                $json[$bookId] = $data;
                Storage::put($jsonPath, json_encode($json));
                Log::info("Finished Book: {$bookId}");
            }
        }

        }catch (\Exception $e){
            Log::error("Big Exception: {$e->getMessage()}");
        }
        return 0;
    }
}
