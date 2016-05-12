var suz = {
  clean: function() {
    $('*[role="block"]')
     .removeAttr('role')
     .removeAttr('drag')
     .removeAttr('bid');
    
    $('*[role="module"]')
     .removeAttr('role')
     .removeAttr('drag')
     .removeAttr('mid');
  },
  init_sortable: function () {
    $('*[role="block"]').each(function() {
    var that = $(this);
    if (that.attr('drag') === 'true') {
      that.addClass('suzblockable');
      that.find('*[role="module"]')
      .addClass('suzmodule')
      .append('<div class="suzblock-icons hide"><i class="handle fa fa-arrows" title="Di chuyển để thay đổi vị trí module"></i><i class="fa fa-info tt" title="Click để xem trợ giúp"></i></div>')
      .hover(function() {
         $(this).find('.suzblock-icons').removeClass("hide");
       }, function() {
         $(this).find('.suzblock-icons').addClass("hide");
       }
      );
    }
  });

  $('.suzblockable').sortable({
    cursor: 'move',
    opacity: 0.5,
    revert: true,
    zIndex: 9999,
    connectWith: '.suzblockable',
    handle: '.handle',
    start: function  (event, ui) {
      ui.placeholder.parent().addClass('suzblock-highligt');
    },
    change: function  (event, ui) {
      ui.placeholder.parent().addClass('suzblock-highligt');
      ui.item.parent().removeClass('suzblock-highligt');
    },
    update: function  (event, ui) {
      ui.item.parent().removeClass('suzblock-highligt');
    }
   }).disableSelection();
  },
  
  add_setting_button: function () {
    $('body').append ('<div class="suzsetting"><i class="fa fa-gear"></i></div>');
    
    $('.suzsetting').hover(function() {
       $(this).animate({'right': '0px'});
     }, function() {
       $(this).animate({'right': '-220px'});
     });
  }
};

$(document).ready(function() {
  //suz.init_sortable();
  //suz.add_setting_button();
  suz.clean();
});