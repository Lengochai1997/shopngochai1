var BaseShowHideItem = function() {
  var initIconSearch = function(){
    var $searchLMHT = jQuery('.lmht-list > div');
    var $searchValue = '';


    jQuery('.js-khung-search').on('change', function(){
      $searchValue = jQuery(this).val().toLowerCase();
      $searchLMHT.hide();
      $searchKhung = parseInt(jQuery(this).val());
      
      if ($searchKhung > 0) {
        jQuery.each($searchLMHT, function(){
          $khung = jQuery(this).data("filter-khung");
          switch($searchKhung)
          {
            case 1:
              if ($khung === 'khongkhung') {
                jQuery(this).show();
              }
              break;
            case 2:
              if ($khung === 'bac') {
                jQuery(this).show();
              }
              break;
            case 3:
              if ($khung === 'vang') {
                jQuery(this).show();
              }
              break;
            case 4:
              if ($khung === 'bachkim') {
                jQuery(this).show();
              }
              break;
            case 5:
              if ($khung === 'kimcuong') {
                jQuery(this).show();
              }
              break;
            case 6:
              if ($khung === 'caothu') {
                jQuery(this).show();
              }
              break;
            case 7:
              if ($khung === 'thachdau') {
                jQuery(this).show();
              }
              break;
          }
        });
      } else {
        $searchLMHT.show();
      }
    });

    jQuery('.js-rank-search').on('change', function(){
      $searchValue = jQuery(this).val().toLowerCase();
      $searchLMHT.hide();
      $searchRank = parseInt(jQuery(this).val());
      
      if ($searchRank > 0) {
        jQuery.each($searchLMHT, function(){
          $rank = jQuery(this).data("filter-rank");
          switch($searchRank)
          {
            case 1:
              if ($rank === 'provisional') {
                jQuery(this).show();
              }
              break;
            case 2:
              if ($rank === 'bronze') {
                jQuery(this).show();
              }
              break;
            case 3:
              if ($rank === 'silver') {
                jQuery(this).show();
              }
              break;
            case 4:
              if ($rank === 'gold') {
                jQuery(this).show();
              }
              break;
            case 5:
              if ($rank === 'platinum') {
                jQuery(this).show();
              }
              break;
            case 6:
              if ($rank === 'diamond') {
                jQuery(this).show();
              }
              break;
            case 7:
              if ($rank === 'master') {
                jQuery(this).show();
              }
              break;
            case 8:
              if ($rank === 'challenger') {
                jQuery(this).show();
              }
              break;
          }
        });
      } else {
        $searchLMHT.show();
      }
    });
    
    jQuery('.js-price-search').on('change', function(){
      $searchValue = jQuery(this).val().toLowerCase();
      $searchLMHT.hide();
      $searchPrice = parseInt(jQuery(this).val());
      
      if ($searchPrice > 0) {
        jQuery.each($searchLMHT, function(){
          $price = parseInt(jQuery(this).data("filter-price"));
          switch($searchPrice)
          {
            case 1:
              if ($price <= 50000) {
                jQuery(this).show();
              }
              break;
            case 2:
              if ($price >= 50000 && $price <= 100000) {
                jQuery(this).show();
              }
              break;
            case 3:
              if ($price >= 100000 && $price <= 500000) {
                jQuery(this).show();
              }
              break;
            case 4:
              if ($price >= 500000 && $price <= 1000000) {
                jQuery(this).show();
              }
              break;
            case 5:
              if (jQuery(this).data("filter-price") >= 1000000) {
                jQuery(this).show();
              }
              break;
          }
        });
      } else {
        $searchLMHT.show();
      }
    });

  };
  return {
    init: function() {
      initIconSearch();
    }
  };
}();
jQuery(function(){ BaseShowHideItem.init(); });