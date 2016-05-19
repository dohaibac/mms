<div class="dashboard-main">
  <div class="col-lg-12 header-title">
    <h1><i class="fa fa-th"></i> Lịch Công Tác</h1>
  </div>
  <div class="table-responsive">
    {literal}

        <div class="content">
          <h1>Nice To-Do List</h1>
          <p class="tagline">an angularJS todo app</p>
          <form>
            <div class="inputContainer">
              <input type="text" id="description" class="taskName" placeholder="What do you need to do?" ng-model="newTask">
              <label for="description">Description</label>
            </div>
            <div class="inputContainer half last"> <i class="fa fa-caret-down selectArrow"></i>
              <select id="category" class="taskCategory" ng-model="newTaskCategory" ng-options="obj.name for obj in categories">
                <option class="disabled" value="">Choose a category</option>
              </select>
              <label for="category">Category</label>
            </div>
            <div class="inputContainer half last right">
              <input type="date" id="dueDate" class="taskDate" ng-model="newTaskDate">
              <label for="dueDate">Due Date</label>
            </div>
            <div class="row">
              <button class="taskAdd" ng-click="addNew()"><i class="fa fa-plus icon"></i>Add task</button>
              <button class="taskDelete" ng-click="deleteTask()"><i class="fa fa-trash-o icon"></i>Delete Tasks</button>
            </div>
          </form>
          <ul  class="taskList">
            <li class="taskItem" ng-repeat="taskItem in taskItem track by $index" ng-model="taskItem">
              <input type="checkbox" class="taskCheckbox" ng-model="taskItem.complete" ng-change="save()">
              <span class="complete-{{taskItem.complete}}">{{taskItem.description}}</span> <span class="category-{{taskItem.category}}">{{taskItem.category}}</span> <strong class="taskDate complete-{{taskItem.complete}}"><i class="fa fa-calendar"></i>{{taskItem.date | date : 'mediumDate'}}</strong> </li>
          </ul>
          <!-- taskList --> 
        </div>
        <!-- content --> 

      <!-- container --> 
    {/literal}
  </div> <!-- end list-->
</div>
