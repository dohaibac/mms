app.directive('bsDropdown', function ($compile, $http) {
  return {
    restrict: 'E',
    scope: {
      items: '=dropdownData',
      doSelect: '&selectVal',
      selectedItem: '=preselectedItem'
    },
    link: function (scope, element, attrs) {
      var html = '';
      switch (attrs.menuType) {
        case "button":
          html += '<div class="btn-group"><button class="btn button-sm btn-info">Action</button><button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>';
          break;
        default:
          html += '<div class="dropdown" dropdown><a class="dropdown-toggle" role="button" dropdown-toggle href="javascript:;">Select Website</a>';
          break;
        }
        
        html += '<ul class="dropdown-menu with-arrow pull-right" role="menu"><li ng-repeat="item in items"><a tabindex="-1" data-ng-click="selectVal(item)">{{item.name}}</a></li></ul></div>';
        element.append($compile(html)(scope));
        for (var i = 0; i < scope.items.length; i++) {
          if (scope.items[i].id === scope.selectedItem) {
            scope.bSelectedItem = scope.items[i];
            break;
          }
        }
        
        scope.selectVal = function (item) {
          if (!item) return;
          switch (attrs.menuType) {
            case "button":
              $('button.button-label', element).html(item.name);
              break;
            default:
              $('a.dropdown-toggle', element).html(item.name + '<i class="caret"></i>');
              break;
          }
          
          scope.doSelect({
            selectedVal: item.id
          });
        };
        
        scope.selectVal(scope.bSelectedItem);
      }
    };
});