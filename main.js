$(function () {
// alert("ok");
    /*
     * Slideshow
     */
    $('.slideshow').each(function () {

    // 螟画焚縺ｮ貅門ｙ
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        var $container = $(this),                                 // a
            $slideGroup = $container.find('.slideshow-slides'),   // b
            $slides = $slideGroup.find('.slide'),                 // c
            $nav = $container.find('.slideshow-nav'),             // d
            $indicator = $container.find('.slideshow-indicator'), // e
            // 繧ｹ繝ｩ繧､繝峨す繝ｧ繝ｼ蜀��蜷�ｦ∫ｴ縺ｮ jQuery 繧ｪ繝悶ず繧ｧ繧ｯ繝
            // a 繧ｹ繝ｩ繧､繝峨す繝ｧ繝ｼ蜈ｨ菴薙�繧ｳ繝ｳ繝�リ繝ｼ
            // b 蜈ｨ繧ｹ繝ｩ繧､繝峨�縺ｾ縺ｨ縺ｾ繧 (繧ｹ繝ｩ繧､繝峨げ繝ｫ繝ｼ繝)
            // c 蜷�せ繝ｩ繧､繝
            // d 繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ (Prev/Next)
            // e 繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ (繝峨ャ繝)

            slideCount = $slides.length, // 繧ｹ繝ｩ繧､繝峨�轤ｹ謨ｰ
            indicatorHTML = '',          // 繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ繧ｳ繝ｳ繝�Φ繝
            currentIndex = 0,            // 迴ｾ蝨ｨ縺ｮ繧ｹ繝ｩ繧､繝峨�繧､繝ｳ繝�ャ繧ｯ繧ｹ
            duration = 500,              // 谺｡縺ｮ繧ｹ繝ｩ繧､繝峨∈縺ｮ繧｢繝九Γ繝ｼ繧ｷ繝ｧ繝ｳ縺ｮ謇隕∵凾髢
            easing = 'easeInOutExpo',    // 谺｡縺ｮ繧ｹ繝ｩ繧､繝峨∈縺ｮ繧｢繝九Γ繝ｼ繧ｷ繝ｧ繝ｳ縺ｮ繧､繝ｼ繧ｸ繝ｳ繧ｰ縺ｮ遞ｮ鬘
            interval = 3500,             // 閾ｪ蜍輔〒谺｡縺ｮ繧ｹ繝ｩ繧､繝峨↓遘ｻ繧九∪縺ｧ縺ｮ譎る俣
            timer;                       // 繧ｿ繧､繝槭�縺ｮ蜈･繧檎黄


    // HTML 隕∫ｴ縺ｮ驟咲ｽｮ縲∫函謌舌∵諺蜈･
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // 蜷�せ繝ｩ繧､繝峨�菴咲ｽｮ繧呈ｱｺ螳壹＠縲
        // 蟇ｾ蠢懊☆繧九う繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ繧｢繝ｳ繧ｫ繝ｼ繧堤函謌
        $slides.each(function (i) {
            $(this).css({ left: 100 * i + '%' });
            indicatorHTML += '<a href="#">' + (i + 1) + '</a>';
        });

        // 繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｫ繧ｳ繝ｳ繝�Φ繝�ｒ謖ｿ蜈･
        $indicator.html(indicatorHTML);


    // 髢｢謨ｰ縺ｮ螳夂ｾｩ
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // 莉ｻ諢上�繧ｹ繝ｩ繧､繝峨ｒ陦ｨ遉ｺ縺吶ｋ髢｢謨ｰ
        function goToSlide (index) {
            // 繧ｹ繝ｩ繧､繝峨げ繝ｫ繝ｼ繝励ｒ繧ｿ繝ｼ繧ｲ繝�ヨ縺ｮ菴咲ｽｮ縺ｫ蜷医ｏ縺帙※遘ｻ蜍
            $slideGroup.animate({ left: - 100 * index + '%' }, duration, easing);
            // 迴ｾ蝨ｨ縺ｮ繧ｹ繝ｩ繧､繝峨�繧､繝ｳ繝�ャ繧ｯ繧ｹ繧剃ｸ頑嶌縺
            currentIndex = index;
            // 繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ縺ｨ繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ迥ｶ諷九ｒ譖ｴ譁ｰ
            updateNav();
        }

        // 繧ｹ繝ｩ繧､繝峨�迥ｶ諷九↓蠢懊§縺ｦ繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ縺ｨ繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ繧呈峩譁ｰ縺吶ｋ髢｢謨ｰ
        function updateNav () {
            var $navPrev = $nav.find('.prev'), // Prev (謌ｻ繧) 繝ｪ繝ｳ繧ｯ
                $navNext = $nav.find('.next'); // Next (騾ｲ繧) 繝ｪ繝ｳ繧ｯ
            // 繧ゅ＠譛蛻昴�繧ｹ繝ｩ繧､繝峨↑繧 Prev 繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ繧堤┌蜉ｹ縺ｫ
            if (currentIndex === 0) {
                $navPrev.addClass('disabled');
            } else {
                $navPrev.removeClass('disabled');
            }
            // 繧ゅ＠譛蠕後�繧ｹ繝ｩ繧､繝峨↑繧 Next 繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ繧堤┌蜉ｹ縺ｫ
            if (currentIndex === slideCount - 1) {
                $navNext.addClass('disabled');
            } else {
                $navNext.removeClass('disabled');
            }
            // 迴ｾ蝨ｨ縺ｮ繧ｹ繝ｩ繧､繝峨�繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ繧堤┌蜉ｹ縺ｫ
            $indicator.find('a').removeClass('active')
                .eq(currentIndex).addClass('active');
        }

        // 繧ｿ繧､繝槭�繧帝幕蟋九☆繧矩未謨ｰ
        function startTimer () {
            // 螟画焚 interval 縺ｧ險ｭ螳壹＠縺滓凾髢薙′邨碁℃縺吶ｋ縺斐→縺ｫ蜃ｦ逅�ｒ螳溯｡
            timer = setInterval(function () {
                // 迴ｾ蝨ｨ縺ｮ繧ｹ繝ｩ繧､繝峨�繧､繝ｳ繝�ャ繧ｯ繧ｹ縺ｫ蠢懊§縺ｦ谺｡縺ｫ陦ｨ遉ｺ縺吶ｋ繧ｹ繝ｩ繧､繝峨�豎ｺ螳
                // 繧ゅ＠譛蠕後�繧ｹ繝ｩ繧､繝峨↑繧画怙蛻昴�繧ｹ繝ｩ繧､繝峨∈
                var nextIndex = (currentIndex + 1) % slideCount;
                goToSlide(nextIndex);
            }, interval);
        }

        // 繧ｿ繧､繝槭�繧貞●豁｢繧矩未謨ｰ
        function stopTimer () {
            clearInterval(timer);
        }


    // 繧､繝ｳ繝吶Φ繝医�逋ｻ骭ｲ
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // 繝翫ン繧ｲ繝ｼ繧ｷ繝ｧ繝ｳ縺ｮ繝ｪ繝ｳ繧ｯ縺後け繝ｪ繝�け縺輔ｌ縺溘ｉ隧ｲ蠖薙☆繧九せ繝ｩ繧､繝峨ｒ陦ｨ遉ｺ
        $nav.on('click', 'a', function (event) {
            event.preventDefault();
            if ($(this).hasClass('prev')) {
                goToSlide(currentIndex - 1);
            } else {
                goToSlide(currentIndex + 1);
            }
        });

        // 繧､繝ｳ繧ｸ繧ｱ繝ｼ繧ｿ繝ｼ縺ｮ繝ｪ繝ｳ繧ｯ縺後け繝ｪ繝�け縺輔ｌ縺溘ｉ隧ｲ蠖薙☆繧九せ繝ｩ繧､繝峨ｒ陦ｨ遉ｺ
        $indicator.on('click', 'a', function (event) {
            event.preventDefault();
            if (!$(this).hasClass('active')) {
                goToSlide($(this).index());
            }
        });

        // 繝槭え繧ｹ縺御ｹ励▲縺溘ｉ繧ｿ繧､繝槭�繧貞●豁｢縲√�縺壹ｌ縺溘ｉ髢句ｧ
        $container.on({
            mouseenter: stopTimer,
            mouseleave: startTimer
        });


    // 繧ｹ繝ｩ繧､繝峨す繝ｧ繝ｼ縺ｮ髢句ｧ
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // 譛蛻昴�繧ｹ繝ｩ繧､繝峨ｒ陦ｨ遉ｺ
        goToSlide(currentIndex);

        // 繧ｿ繧､繝槭�繧偵せ繧ｿ繝ｼ繝
        startTimer();

    });

    /*
     * Sticky header
     */
    $('.page-header').each(function () {

        var $window = $(window), // Window 繧ｪ繝悶ず繧ｧ繧ｯ繝
            $header = $(this),   // 繝倥ャ繝繝ｼ

            // 繝倥ャ繝繝ｼ縺ｮ繧ｯ繝ｭ繝ｼ繝ｳ
            $headerClone = $header.contents().clone(),

            // 繝倥ャ繝繝ｼ縺ｮ繧ｯ繝ｭ繝ｼ繝ｳ縺ｮ繧ｳ繝ｳ繝�リ繝ｼ
            $headerCloneContainer = $('<div class="page-header-clone"></div>'),

            // HTML 縺ｮ荳願ｾｺ縺九ｉ繝倥ャ繝繝ｼ縺ｮ蠎戊ｾｺ縺ｾ縺ｧ縺ｮ霍晞屬 = 繝倥ャ繝繝ｼ縺ｮ繝医ャ繝嶺ｽ咲ｽｮ + 繝倥ャ繝繝ｼ縺ｮ鬮倥＆
            threshold = $header.offset().top + $header.outerHeight();

        // 繧ｳ繝ｳ繝�リ繝ｼ縺ｫ繝倥ャ繝繝ｼ縺ｮ繧ｯ繝ｭ繝ｼ繝ｳ繧呈諺蜈･
        $headerCloneContainer.append($headerClone);

        // 繧ｳ繝ｳ繝�リ繝ｼ繧 body 縺ｫ謖ｿ蜈･
        $headerCloneContainer.appendTo('body');

        // 繧ｹ繧ｯ繝ｭ繝ｼ繝ｫ譎ゅ↓蜃ｦ逅�ｒ螳溯｡後☆繧九′縲∝屓謨ｰ繧 1 遘帝俣縺ゅ◆繧 30 縺ｾ縺ｧ縺ｫ蛻ｶ髯
        $window.on('scroll', $.throttle(1000 / 15, function () {
            if ($window.scrollTop() > threshold) {
                $headerCloneContainer.addClass('visible');
            } else {
                $headerCloneContainer.removeClass('visible');
            }
        }));

        // 繧ｹ繧ｯ繝ｭ繝ｼ繝ｫ繧､繝吶Φ繝医ｒ逋ｺ逕溘＆縺帙∝�譛滉ｽ咲ｽｮ繧呈ｱｺ螳
        $window.trigger('scroll');
    });
 
  // ①タブをクリックしたら発動
  $('.tab li').click(function() {
 
    // ②クリックされたタブの順番を変数に格納
    var index = $('.tab li').index(this);
 
    // ③クリック済みタブのデザインを設定したcssのクラスを一旦削除
    $('.tab li').removeClass('active');
 
    // ④クリックされたタブにクリック済みデザインを適用する
    $(this).addClass('active');
 
    // ⑤コンテンツを一旦非表示にし、クリックされた順番のコンテンツのみを表示
    $('.area ul').removeClass('show').eq(index).addClass('show');
 
  });
  
  $('.tab_btn').on('click', function() {
    $('.tab_item').removeClass("is-active-item");
    $($(this).attr("section")).addClass("is-active-item");

    //以下２行を追加
    $('.tab_btn').removeClass('is-active-btn');
    $(this).addClass('is-active-btn');
  });
    // var position = $("任意の要素")?.offset()?.top;
});

//フィるたー
var searchBox = '.search-box'; // 絞り込む項目を選択するエリア
var listItem = '.list_item';   // 絞り込み対象のアイテム
var hideClass = 'is-hide';     // 絞り込み対象外の場合に付与されるclass名

$(function() {
	// 絞り込み項目を変更した時
	$(document).on('change', searchBox + ' input', function() {
		search_filter();
	});
});

/**
 * リストの絞り込みを行う
 */
function search_filter() {
	// 非表示状態を解除
	$(listItem).removeClass(hideClass);
	for (var i = 0; i < $(searchBox).length; i++) {
		var name = $(searchBox).eq(i).find('input').attr('name');
		// 選択されている項目を取得
		var searchData = get_selected_input_items(name);
		// 選択されている項目がない、またはALLを選択している場合は飛ばす
		if(searchData.length === 0 || searchData[0] === '') {
			continue;
		}
		// リスト内の各アイテムをチェック
		for (var j = 0; j < $(listItem).length; j++) {
			// アイテムに設定している項目を取得
			var itemData = $(listItem).eq(j).data(name);
			// 絞り込み対象かどうかを調べる
			if(searchData.indexOf(itemData) === -1) {
				$(listItem).eq(j).addClass(hideClass);
			}
		}
	}
}

/**
 * inputで選択されている値の一覧を取得する
 * @param  {String} name 対象にするinputのname属性の値
 * @return {Array}       選択されているinputのvalue属性の値
 */
function get_selected_input_items(name) {
	var searchData = [];
	$('[name=' + name + ']:checked').each(function() {
		searchData.push($(this).val());
	});
	return searchData;
}
// google map
var map;
var markerD = [];
var marker = [];
var infoWindow = [];
var openWindow;

function initMap() {
    //マップ初期表示の位置設定
    var target = document.getElementById('target');
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            // 現在地の緯度経度所得
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            
            var centerp = {lat: lat, lng: lng};
            
            //マップ表示
            map = new google.maps.Map(target, {
                center: centerp,
                zoom: 10,
            });
            
            // マーカーの新規出力
            new google.maps.Marker({
                map: map,
                position: centerp,
                icon: {
            		path: 'M -8,-8 8,8 M 8,-8 -8,8',     //座標（×）
            		strokeColor: "#000000",              //線の色
            		strokeWeight: 4.0                    //線の太さ
            	}
            });
        }
    );  
}


$(function(){
    $.ajax({
        type: "POST",
        url: "all_exams.php",
        dataType: "json",
        success: function(data){
            markerD = data;
            setMarker(markerD);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Error : ' + errorThrown);
        }
    });
});


function setMarker(markerData) {

    //マーカー生成
    var sidebar_html = "";
    var icon;
    
    for (var i = 0; i < markerData.length; i++) {
        console.log(i + "番目：" + markerData[i]['address'] + "/" + markerData[i]['lat'] + "/" + markerData[i]['lng']);

        var latNum = parseFloat(markerData[i]['lat']);
        var lngNum = parseFloat(markerData[i]['lng']);
        // マーカー位置セット
        var markerLatLng = new google.maps.LatLng({
            lat: latNum,
            lng: lngNum
        });
        
        
        // マーカーのセット
        marker[i] = new google.maps.Marker({
            position: markerLatLng,          // マーカーを立てる位置を指定
            map: map,                        // マーカーを立てる地図を指定
            // icon: {
            //     url: 'spot.png',
            //     size : new google.maps.Size(19, 25)
            // }
        });
        
        // 吹き出しの追加
        infoWindow[i] = new google.maps.InfoWindow({
            content: markerData[i]['year'] + '/' + markerData[i]['month'] + '/' + markerData[i]['day'] + ':　'+ markerData[i]['exam_name'] + '<br><br>' +'<a href="' + markerData[i]['url'] + '" target="_blank">' + markerData[i]['address'] + '</a>'
        });
        // サイドバー
        
        sidebar_html +=  '● '+ '<a href="javascript:myclick(' + i + ')">' + markerData[i]['exam_name'] + '<\/a><br />';
        // マーカーにクリックイベントを追加
        markerEvent(i);
    }
    
   // Marker clusterの追加
    var markerCluster = new MarkerClusterer(
        map,
        marker,
        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
    );
    
    // サイドバー
    document.getElementById("sidebar").innerHTML = sidebar_html;
}


function markerEvent(i) {
    marker[i].addListener('click', function() {
        myclick(i);
    });
}

function myclick(i) {
    if(openWindow){
        openWindow.close();
    }
    infoWindow[i].open(map, marker[i]);
    openWindow = infoWindow[i];
}