using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Data;
using System.IO;

public partial class jQueryAutoComp_ACDataSrc : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //使用者目前輸入的文字預設以q傳入
        string q = Request["q"] ?? "";
        if (q.Length > 0)
        {
            DataTable t = getStockData();
            DataView dv = new DataView(t);
            //利用LIKE做查詢
            dv.RowFilter = "Key LIKE '" + q + "%'";
            dv.Sort = "Key, Symbol";
            List<string> lst = new List<string>();
            lst.Add("");
            foreach (DataRowView drv in dv)
            {
                DataRow r = drv.Row;
                //組裝出前端要用的欄位
                lst.Add(string.Format("{0}|{1}|{2}", r["key"], r["symbol"], r["cname"]));
                if (lst.Count >= 10) break;
            }
            //每筆資料間以換行分隔
            Response.Write(string.Join("\n", lst.ToArray()));
        }
    }

    private DataTable getStockData()
    {
        #region 股票代號
        string rawData = @"
1435	中福	C.F.C.Y.CORP.
1437	勤益	GTM
1471	首利	SL
1604	聲寶	SAMPO
2301	光寶科	LTC
2302	麗正	RECTRON
2303	聯電	UMC
2305	全友	MII
2308	台達電	DELTA
2311	日月光	ASE
2312	金寶	KINPO
2313	華通	COMPEQ MFG.
2314	台揚	MTI
2315	神達	MIC
2316	楠梓電	WUS
2317	鴻海	HON HAI
2321	東訊	TECOM
2323	中環	CMC
2324	仁寶	Compal
2325	矽品	SPIL
2327	國巨	YAGEO
2328	廣宇	PI
2329	華泰	OSE
2330	台積電	TSMC
2331	精英	ECS
2332	友訊	D-LINK
2336	致伸	Primax
2337	旺宏	MXIC
2338	光罩	TMC
2340	光磊	OPTO TECH
2341	英群	BTC
2342	茂矽	MVI
2344	華邦電	WEC
2345	智邦	ACCTON
2347	聯強	Synnex
2348	力廣	VEUTRON
2349	錸德	RITEK
2350	環電	USI
2351	順德	SDI
2352	明基	BENQ
2353	宏碁	ACER
2354	鴻準	FTC
2355	敬鵬	CHIN-POON
2356	英業達	INVENTEC
2357	華碩	ASUSTEK
2358	美格	MAG
2359	所羅門	SOLOMON
2360	致茂	CHROMA
2361	鴻友	MUSTEK
2362	藍天	CLEVO CO.
2363	矽統	SiS
2364	倫飛	Twinhead
2365	昆盈	KYE
2367	燿華	UNITECH
2368	金像電	GCE
2369	菱生	LPI
2371	大同	TATUNG CO.
2373	震旦行	Aurora
2374	佳能	ABILITY
2375	智寶	Teapo
2376	技嘉	GIGABYTE
2377	微星	MSI
2380	虹光	AVISION
2381	華宇	ARIMA
2382	廣達	QCI
2383	台光電	EMC
2384	勝華	WINTEK CORP.
2385	群光	CHICONY
2387	精元	SUNREX
2388	威盛	VIA
2390	云辰	EVERSPRING
2391	合勤	ZyXEL
2392	正崴	FOXLINK
2393	億光	EVERLIGHT
2395	研華	ACL
2396	精碟	PRODISC
2397	友通	DFI Inc.
2399	映泰	BIOSTAR
2401	凌陽	SUNPLUS
2402	毅嘉	ICHIA
2403	友尚	YOSUN
2404	漢唐	UIS
2405	浩鑫	SHUTTLE
2406	國碩	GSC
2408	南科	NTC
2409	友達	AUO
2411	飛瑞	PPC
2412	中華電	CHT
2413	環科	UMEC
2414	精技	UTE
2415	錩新	CX TECH
2417	圓剛	AVERMEDIA
2419	仲琦	H.T.
2420	新巨	ZIPPY
2421	建準	SUNON
2423	固緯	GW
2424	隴華	LUNG HWA
2425	承啟	CHAINTECH
2426	鼎元	TYNTEK
2427	三商電	MDS
2428	興勤	THINKING
2430	燦坤	TKE
2431	聯昌	LIEN CHANG
2432	倚天	ETEN
2433	互盛電	ASC
2434	統懋	MOSPEC
2436	偉詮電	Weltrend
2437	旺詮	RALEC
2438	英誌	ENLIGHT
2439	美律	MERRY
2440	太空梭	SPACE SHUTTLE
2441	超 豐	GTK
2442	美 齊	JEAN
2443	利 碟	LEADDATA LTD
2444	友 旺	AboCom
2446	全懋	PPt
2447	鼎新	DSC
2448	晶電	EPISTAR
2449	京元電	KYEC
2450	神腦	SENAO
2451	創見	Transcend
2452	乾坤	CYNTEC CO., LTD
2453	凌群	SYSCOM
2454	聯發科	MTK
2455	全新	VPEC
2456	奇力新	CHILISIN
2457	飛宏	PHIHONG
2458	義隆	ELAN
2459	敦吉	AUDIX
2460	建通	GEM
2461	光群雷	K LASER
2462	良得電	LINETEK
2463	研揚	AAEON
2464	盟立	Mirle
2465	麗臺	LEADTEK
2466	冠西電	COSMO
2467	志聖	C SUN
2468	華經	FIS
2469	力信	LSE
2471	資通	ARES
2472	立隆電	LELON
2473	思源	SPRINGSOFT
2474	可成	CATCHER
2475	華映	CPT
2476	鉅祥	GS
2477	美隆電	MEILOON
2480	敦陽科	STARK
2481	強茂	PAN JIT
2482	連宇	UIC
2483	百容	ECE
2484	希華	SIWARD
2485	兆赫	ZINWELL
2486	一詮	I-CHIUN
2488	漢平	HANPIN
2489	瑞軒	AMTRAN
2491	訊碟	Infodisc
2492	華新科	WTC
2493	揚博	AMPOC
2494	突破	TBC
2495	普安	Infortrend
2497	怡利電	E-LEAD
2498	宏達電	HTC
2499	東貝	Unity
3002	歐格	AHOKU
3003	健和興	KST
3005	神基	MTC
3006	晶豪科	ESMT
3008	大立光	LARGAN
3009	奇美電	CMO
3010	華立	WAH LEE
3011	今皓	JH
3013	晟銘電	UNEEC
3014	聯陽	ITE
3015	全漢	FSP
3016	嘉晶	PRECISION
3017	奇鋐	AVC
3019	亞光	ASIA　　
3020	奇普仕	USTC
3022	威達電	ICP
3023	信邦	　　Sinbon
3024	憶聲	ACTION
3025	星通	LOOP
3026	禾伸堂	HOLY STONE　
3027	盛達	BILLION
3028	增你強	ZENITRON
3029	零壹	ZERO ONE 　　
3030	德律	TRI　
3031	佰鴻	BRIGHT　
3032	偉訓	COMPUCASE　　
3033	威健	Weikeng
3034	聯詠	NOVATEK　
3035	智原	Faraday　
3036	文曄	WT　
3037	欣興	UNIMICRON
3038	全台	EDT
3040	遠見	G.V.
3041	揚智	　　ALi
3042	晶技	TXC
3043	科風	PCM
3044	健鼎	Tripod
3045	台灣大	TWM
3046	建碁	AOpen
3047	訊舟	　EDIMAX　
3048	益登	EDOM
3049	和鑫	SINTEK
3050	鈺德	U-TECH
3051	力特	Optimax
3052	夆典	APEX
3054	萬國	CARRY
3055	蔚華科	Spirox Corp.
3057	喬鼎	Promise　　
3058	立德	LEI　　
3059	華晶科	Altek
3060	銘異	MIN AIK
3061	璨圓	FOREPI
3062	建漢	CyberTAN　　
3063	飛信	IST
3130	一零四	104
3189	景碩	KINSUS
3231	緯創	Wistron
3271	其樂達	CTK
3311	閎暉	Silitech
3315	宣昶	MAXTEK
3356	奇偶	GeoVision
3367	英華達	IAC
3380	明泰	Alpha
3406	玉晶光	GSEO
3443	創意	GUC
3450	聯鈞	ELASER
3474	華亞科	Inotera
3481	群創	INNOLUX
3504	揚明光	Young Optics
3702	大聯大	WPG
4904	遠傳	Far EasTone　
4906	正文	GEMTEK　
5203	訊連	　　CyberLink
5305	敦南	LSC
5434	崇越	TOPCO
5469	瀚宇博	HSB
5471	松翰	SONIX　　
5484	慧友	EverFocus
6112	聚碩	SYSAGE
6115	鎰勝	I-SHENG　　
6116	彩晶	Hannstar　　
6117	迎廣	IN WIN
6119	大傳	AECO
6120	輔祥	FORHOUSE
6128	上福	GPI　　
6131	悠克	YOKO　　
6133	金橋	　GBE　
6136	富爾特	FTC　　
6139	亞翔	L & K　
6141	柏承	PLOTECH　
6142	友勁	CAMEO
6145	勁永	PQI　
6155	鈞寶	KC　　
6165	捷泰	JTT
6166	凌華	ADLINK　　
6168	宏齊	HARVATEK CORPOR
6172	互億	Billionton　　
6176	瑞儀	ROEC
6189	豐藝	Promate
6192	巨路	LUMAX
6196	帆宣	MIC
6197	佳必琪	JPC
6202	盛群	HOLTEK　
6206	飛捷	FLYTECH　
6209	今國光	KINKO
6216	居易	DrayTek Corp.
6225	天瀚	AIPTEK
6235	華孚	Waffer
6239	力成	PTI
6255	奈普	Nano-Op
6257	矽格	SIGURD　　
6269	台郡	FLEXIUM
6277	宏正	ATEN
6281	全國電	E-LIFE MALL
6282	康舒	AcBel
6285	啟碁	　WNC　
6286	立錡	Richtek
6289	華上	AOC　
8008	建興電	LITE-ON IT
8016	矽創	Sitronix　　
8046	南電	N.P.C
8072	陞泰	AV TECH　
8078	華寶	CCI
8101	華冠	Arima Comm.　　
8105	凌巨	GiantPlus
8249	菱光	CSI　　
9912	偉聯	AIC";
        #endregion

        //如果資料量未多到誇張，將DataTable Cached住
        string CACHE_KEY = "StkTable";
        if (Cache[CACHE_KEY] == null)
        {
            DataTable t = new DataTable();
            t.Columns.Add("Key", typeof(string));
            t.Columns.Add("Symbol", typeof(string));
            t.Columns.Add("CName", typeof(string));
            t.Columns.Add("EName", typeof(string));
            //測試時由字串取得資料，實務上會去查DB
            StringReader sr = new StringReader(rawData);
            string line = null;
            while ((line = sr.ReadLine()) != null)
            {
                string[] p = line.Split('\t');
                if (p.Length != 3) continue;
                //分別以Symbol, CName, EName作Key
                //輸入中英文及代號都可以查
                t.Rows.Add(p[0], p[0], p[1], p[2]);
                t.Rows.Add(p[1], p[0], p[1], p[2]);
                t.Rows.Add(p[2], p[0], p[1], p[2]);
            }
            //放入Cache，保存兩小時
            Cache.Add(CACHE_KEY, t, null, DateTime.Now.AddHours(2),
                System.Web.Caching.Cache.NoSlidingExpiration,
                System.Web.Caching.CacheItemPriority.Normal, null);
        }
        return Cache[CACHE_KEY] as DataTable;
    }


}
