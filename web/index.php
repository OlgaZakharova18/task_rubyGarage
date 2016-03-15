<?php 

session_start(); // добавление сессии


header("Content-Type: text/html; charset=utf-8");

			
		//подключение к бд
		$connect = mysql_connect('localhost','root','') or die(mysql_error());
		mysql_select_db('db_ruby', $connect);

		
		//регистрация
		if(isset($_POST['submit'])){											
			$username = $_POST['username'];
			$login = $_POST['login'];
			$password = $_POST['password'];
			$query = mysql_query("INSERT INTO user VALUES('','$username','$login', md5('$password'))") or die(mysql_error());
		}


		//обработчик для удаления проэкта
		if(isset($_POST['pcontrols'])){
			$project_id=$_POST['id'];		
			$work=$_POST['type'];
			switch($work){				
			case 1: 
					$user = $_SESSION['user_id'];
					$newName=$_POST['newName'];
					if(!mysql_query("UPDATE project SET name_project = '$newName' WHERE id_project = $project_id AND id_user = $user")){
						exit;
					}						
				break;
		
			case 2: 
					$user = $_SESSION['user_id'];
					$query = mysql_query("DELETE FROM task WHERE id_project = $project_id AND id_user=$user") or die(mysql_error());
					if (!$query) {
						exit;
					}
					$query = mysql_query("DELETE FROM project WHERE id_project = $project_id AND id_user=$user") or die(mysql_error());
					if (!$query) {						
						exit;
					}
				break;
			case 3: 
					$user = $_SESSION['user_id'];
					$newName=$_POST['newName'];
					$query = mysql_query("SELECT COUNT( * ) +1 AS  'count' FROM task WHERE id_user = $user AND id_project = $project_id") or die(mysql_error());
					if (!$query) {
						exit;
					}
					$user_data = mysql_fetch_array($query);	
					if($user_data[0]){						
						$count = $user_data['count'];
						$query = mysql_query("INSERT INTO task VALUES('', '$newName', $project_id, $user ,0, $count)") or die(mysql_error());
						if (!$query) {
							exit;
						}
					}
				break;
			}
			render_project();
			exit;
		}
		
		
		
		
		
		
		
		//обработчик для тасков
		if(isset($_POST['tcontrols'])){
			$task_id=$_POST['id'];		
			$work=$_POST['type'];
			$project = $_POST['project'];
			switch($work){				
			case 1: 
					$user = $_SESSION['user_id'];
					$newName=$_POST['newTaskName'];
					if(!mysql_query("UPDATE task SET name_task = '$newName' WHERE id_task = $task_id AND id_user = $user AND id_project=$project")){
						exit;
					}						
				break;
		
			case 2: 
					$user = $_SESSION['user_id'];
					$query = mysql_query("DELETE FROM task WHERE id_project = $project AND id_user=$user AND id_task=$task_id") or die(mysql_error());
					if (!$query) {
						
						exit;
					}
				break;
			case 3: 
					$user = $_SESSION['user_id'];
					$newName=$_POST['newName'];
					$query = mysql_query("SELECT priority FROM task WHERE id_project = $project AND id_user=$user AND id_task = $task_id")or die(mysql_error());
					$data = mysql_fetch_array($query);						
					$cur_priority = $data[0];
					$query = mysql_query("SELECT MAX(priority) AS  'prior' FROM task WHERE id_project = $project AND id_user=$user AND priority < $cur_priority")or die(mysql_error());
					$data = mysql_fetch_array($query);
					$prev_prior = $data[0];
					if(strlen($prev_prior) == 0)
					{
						break;						
						}
					mysql_query("UPDATE task SET priority = -1 where id_project = $project AND id_user=$user AND priority = $prev_prior")or die(mysql_error());
					mysql_query("UPDATE task Set priority = $prev_prior where id_project = $project AND id_user=$user AND priority = $cur_priority")or die(mysql_error());
					mysql_query("UPDATE task Set priority = $cur_priority where id_project = $project AND id_user=$user AND priority = -1")or die(mysql_error());
				break;
			case 4: 
					$user = $_SESSION['user_id'];
					$newName=$_POST['newName'];
					$query = mysql_query("SELECT priority FROM task WHERE id_project = $project AND id_user=$user AND id_task = $task_id")or die(mysql_error());
					$data = mysql_fetch_array($query);						
					$cur_priority = $data[0];
					$query = mysql_query("SELECT MIN(priority) AS  'prior' FROM task WHERE id_project = $project AND id_user=$user AND priority > $cur_priority")or die(mysql_error());
					$data = mysql_fetch_array($query);
					$prev_prior = $data[0];
					if(strlen($prev_prior) == 0)
					{
						break;						
						}
					mysql_query("UPDATE task SET priority = -1 where id_project = $project AND id_user=$user AND priority = $prev_prior")or die(mysql_error());
				    mysql_query("UPDATE task SET priority = $prev_prior where id_project = $project AND id_user=$user AND priority = $cur_priority")or die(mysql_error());
					mysql_query("UPDATE task SET priority = $cur_priority where id_project = $project AND id_user=$user AND priority = -1")or die(mysql_error());
				break;
			case 5: 
			$user = $_SESSION['user_id'];
			 mysql_query("UPDATE task SET id_state = CASE WHEN id_state = 0 THEN 1 ELSE 0 END WHERE id_project=$project AND id_user=$user AND id_task=$task_id")or die(mysql_error());
			
			break;
			}
			render_project();
			exit;
		}
		
		
			
		

		
			
			if(isset($_POST['add_project'])){
					if(!isset($_SESSION['user_id'])){
						exit;
					}
					$user = $_SESSION['user_id'];
					$query = mysql_query("SELECT COUNT( * ) +1 AS  'count' FROM project WHERE id_user = $user") or die(mysql_error());
					if (!$query) {
						exit;
					}
					$user_data = mysql_fetch_array($query);	
					if($user_data[0]){						
						$count = $user_data['count'];
						$query = mysql_query("INSERT INTO project VALUES('','', $user ,0, $count)") or die(mysql_error());
						if (!$query) {						
							echo mysql_error();						
							exit;					
						}
						else{
							ob_end_clean();					
							render_project();
							exit;
						}
					}
					else{
						echo "no_count";
					}
				}
				
		include ($_SERVER["DOCUMENT_ROOT"]."/title_index.html"); 
		
		
		//авторизация
		
		$check = false; 
		if(isset($_POST['enter'])){
			$e_log = $_POST['e_log'];
			$e_password = $_POST['e_password'];
			$query = mysql_query("SELECT id_user FROM user WHERE login_user = '$e_log' AND password_user=md5('$e_password')");			
			if (!$query) {
				exit;
			}
			$user_data = mysql_fetch_array($query);	
			if($user_data['id_user']){
				$check = true;				
				$user_id = $user_data['id_user'];
				$_SESSION['user_id']= $user_id;	
				$_SESSION['check']= $check;	
				render_project();
			}
			else{
				echo "Wrong password or login";
			}
		}

		
		
		//Разлогинивание, выход из сессии
		if(isset($_POST['logout'])){
			unset($_SESSION['name']);
			session_destroy();
		}





		// добавление формы

		function render_project() {
					$user = $_SESSION['user_id'];
					
					$query = mysql_query("SELECT id_project, name_project, id_state, priority FROM  `project` WHERE id_user =$user ORDER BY priority");
					if (!$query) {
						exit;
					}
					echo '<div class="row" id="output">	';			
					while($project_data = mysql_fetch_row($query)){
						$param2 = (strlen($project_data[1])==0 ? "'Введите имя проекта'" : $project_data[1]);
						echo '	<div id="'.$project_data[0].'">	
							<!-- шапка окна для заполнения-->
									<div class="header_main">
										<div class="row">									
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
												<span class="glyphicon glyphicon glyphicon-tasks btn-lg"></span>					
											</div>
											<div class="col-lg-8 col-md-7 col-sm-6 col-xs-10" class="addit_name" id="addit_name'.$project_data[0].'">
												<p class="lead">'.$project_data[1].'</p>					
											</div>
											<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 ">
												<button type="button" class="btn btn-link" onclick="editProjectName('.$project_data[0].','.$param2.')"><span class="glyphicon glyphicon glyphicon-pencil btn-lg"></span></button>
												<button type="button" id="del_div" class="btn btn-link" onclick="inProjectAddTask('.$project_data[0].',2)"><span class="glyphicon glyphicon glyphicon-trash btn-lg"></span></button>
											</div>				
										</div>
									</div>							
							
									<!-- Часть для добавления задач -->
									<div class="task_main">
										<div class="row">
											<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-xs-offset-1 col-xs-10 col-xs-offset-1">
												<div class="box">
													<div class="input-group">
														<input type="text" class="form-control" id="inputAddTask'.$project_data[0].'">	
															<span class="input-group-btn">
															<button class="btn btn-defauld"  type="button" onclick="inProjectAddTask('.$project_data[0].',3)">Add Task</button>
															</span>																																
													</div>																		
												</div>
											</div>							
										</div>										
									</div>';
									render_tasks($project_data[0]);
								echo '</div>';								
					}		
					
				echo '</div>';
		}		
				
				
			 // работа с тасками
				function render_tasks($project_id) {
					$user = $_SESSION['user_id'];
					$query = mysql_query("SELECT id_task, name_task, id_project, id_user, id_state, priority FROM task WHERE id_user = $user AND id_project = $project_id ORDER BY priority");
					if(!$query) {
						exit;
					}
					while($project_task = mysql_fetch_row($query)){
						$paramTask2 = (strlen($project_task[1])==0 ? "'Введите наименование задания'" : $project_task[1]);
						$checked = ($project_task[5]==0) ? 'checked="true"' : "";
						echo'<!-- Часть для добавления задач -->
													
							<div class="task-next" id="nameTask'.$project_task[0].'">
								<div class="row">
									<div class="col-lg-1  col-md-1  col-sm-1  col-xs-2  task-next_check">
										<div class="checkbox">
											<div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-2 col-sm-2 col-sm-offset-2  col-xs-2 col-xs-offset-2 col-xs-pull-4 checkbox_border">
												<label>
												<input type="checkbox" '.$checked.' onclick="inTaskAddTask('.$project_id.','.$project_task[0].',5) checked"> 
												</label>
											</div>
										</div>
									</div>
									
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-5" id="addit_task_name'.$project_task[0].'_'.$project_id.'">
										<p>'.$project_task[1].'</p>										
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 task-next-right">
										<button type="button" class="btn btn-link"><span class="glyphicon glyphicon glyphicon-arrow-up" onclick="inTaskAddTask('.$project_id.','.$project_task[0].',3)"></span></button>
										<button type="button" class="btn btn-link"><span class="glyphicon glyphicon glyphicon-arrow-down" onclick="inTaskAddTask('.$project_id.','.$project_task[0].',4)"></span></button>
										<button type="button" class="btn btn-link"><span class="glyphicon glyphicon glyphicon-pencil" onclick="editTaskName('.$project_task[0].','.$paramTask2.','.$project_id.')"></span></button>
										<button type="button" class="btn btn-link"><span class="glyphicon glyphicon glyphicon-trash" onclick="inTaskAddTask('.$project_id.','.$project_task[0].',2)"></span></button>
									</div>
								</div>
							</div>';
					}		
					echo '<div class="task-first">
							<div class="row">
								<div class="col-lg-1  col-md-1  col-sm-1  col-xs-2  task-first-check">
								</div>								
							</div>
						</div>';
						
				}				
	
					if($check == true){
						echo '
							
							<div class="row botton">
								<div class="col-lg-2 col-lg-offset-4 col-md-2 col-md-offset-4 col-sm-3 col-sm-offset-4 col-xs-4 col-xs-offset-3">
									<button type="button" name="add_project" onclick="create_project()" id="create_project" class="btn btn-primary">
										<span class="glyphicon glyphicon glyphicon-plus"> Add TODO List</span>
									</button>
								</div>    
							</div> ';
						}							
							
					include ($_SERVER["DOCUMENT_ROOT"]."/footer_index.html"); 		
?>	