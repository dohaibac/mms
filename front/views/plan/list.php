<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-th"></i> Lịch Công Tác</h1>
  </div>
  <div class="table-responsive">
    {literal}
      <div class="todo_container">
        <form>
          <div class="content todo_table">
            <div class="todo_row">
              <div class="inputContainer todo_cell">
                <textarea id="description" class="taskName" placeholder="Bạn cần làm gì?" ng-model="newTask"></textarea>
              </div>
            </div>
            <div class="todo_row">
              <div class="inputContainer half last todo_cell"> <i class="fa fa-caret-down selectArrow"></i>
                <select id="category" class="taskCategory" ng-model="newProvinces" ng-options="province as province.name for province in provinces track by province.id">
                  <option class="disabled" value="">Tỉnh Thành</option>
                </select>
                <label for="category">Địa Điểm</label>
              </div>
              <div class="inputContainer half last right todo_cell">
                <label for="dueDate">Thời Gian</label><br/>
                <input datetime-picker ng-model="newTaskDate" />
              </div>
            </div>
            <div class="todo_row">
              <div class="todo_cell">
                <button class="taskAdd" ng-click="addNew()"><i class="fa fa-plus icon"></i>Thêm Mới</button>
                <button class="taskDelete" ng-click="deleteTask()"><i class="fa fa-trash-o icon"></i>Xóa</button>
              </div>
            </div>
          <!-- taskList --> 
          </div>
        </form>
        <ul  class="taskList">
          <li class="taskItem" ng-repeat="taskItem in taskItem track by $index" ng-model="taskItem">
            <input type="checkbox" class="taskCheckbox" ng-model="taskItem.complete" ng-change="save()">
            <span class="complete-{{taskItem.complete}}">{{taskItem.description}}</span> <span class="category-{{taskItem.category}}">{{taskItem.category}}</span> <strong class="taskDate complete-{{taskItem.complete}}"><i class="fa fa-calendar"></i>{{taskItem.date | date : 'mediumDate'}}</strong> </li>
        </ul>
        <!-- content --> 
      </div>
      <!-- container --> 
    {/literal}
  </div> <!-- end list-->
</div>
