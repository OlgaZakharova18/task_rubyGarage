var user_id;

	//создание проэкта
	function create_project(){
         	    $.ajax({
                    type: "POST",
                    url: "http://task/",
                    data: "add_project=1",
                    cache: false,
                    success: function (answer) {
					    $("#output").html(answer);
                    },
                    error: function () {
                        alert('Ошибка при отправке!');
                        repeat();
                    }
                });
                return false;
            }
			
		   

	// авторизация
		function exit(){
		var a = document.getElementsByName('e_log');
		var b = document.getElementsByName('e_password');
		
         	    $.ajax({
                    type: "POST",
                    url: "http://task/",
                    data: "enter=1&e_log="+a+"&e_password="+b,
                    cache: false,
                    success: function (answer) {                     
					},
                    error: function () {
                        alert('Ошибка при отправке!');
                        repeat();
                    }
                });
                return false;
            }
			
			
			
			
  
  
  //Манипуляция с проэктами
  //редактирование
	function editProjectName(bid,pname){
		$("#addit_name"+bid).html('<div class="input-group "><input type="text" class="form-control addit_name_reg" placeholder="'+pname+'"><span class="input-group-btn" ><button class="btn btn-defauld addit_name_reg_button" onclick="inProjectAddTask('+bid+',1)" type="button">Save</button></span></div>');  
	}
  
  function inProjectAddTask(bid,type){
		 
		var params;
		switch(type){
			case 1:
				var targetInput = document.getElementById("addit_name"+bid).getElementsByClassName("form-control")[0];
				params = "id="+bid+"&type="+type+"&pcontrols=1"+"&newName='"+targetInput.value+"'"; 
				
								
				break;	
		//удаление
			case 2: 
				
				params = "id="+bid+"&type="+type+"&pcontrols=2";
					
				break;
		// добавление тасков
			case 3: 
				var targetInput = document.getElementById("inputAddTask"+bid);
				params = "id="+bid+"&type="+type+"&pcontrols=3"+"&newName="+targetInput.value;
				
				break;
		}		
		$.ajax({
					type: "POST",
					url: "http://task/",
					data: params,
					cache: false,
					success: function (answer) {
						$("#output").html(answer); 								
					},
					error: function () {
						alert('Ошибка при отправке!');
						repeat();
					}
				})
				return false;
	  
	}
	
	
	//Манипуляция с тасками
	//редактирование имени
	function editTaskName(tid,tname, pr_id){
		$("#addit_task_name"+tid+"_"+pr_id).html('<div class="input-group"><input type="text" class="form-control addit_name_task" id="inputTaskName'+tid+'_'+pr_id+'" placeholder="'+tname+'"><span class="input-group-btn" ><button class="btn btn-defauld addit_name_task_button" onclick="inTaskAddTask('+pr_id+','+tid+',1)" type="button">Save</button></span></div>');  
	}

  function inTaskAddTask(project,tid,type){
		 
		var params;
		switch(type){
					//имя таска
					case 1:
					var targetInput = document.getElementById("inputTaskName"+tid+"_"+project);			
						$.ajax({							
							type: "POST",
							url: "http://task/",
							data: "id="+tid+"&type="+type+"&tcontrols=1"+"&newTaskName='"+targetInput.value+"'&project="+project,
							cache: false,
							success: function (answer) {
								$("#output").html(answer); 								
							},
							error: function () {
								alert('Ошибка при отправке!');
								repeat();
							}
						})			
					break;	
					//удаление
					case 2: 
						$.ajax({
							type: "POST",
							url: "http://task/",
							data: "id="+tid+"&type="+type+"&tcontrols=2&project="+project,
							cache: false,
							success: function (answer) {
								$("#output").html(answer); 								
							},
							error: function () {
								alert('Ошибка при отправке!');
								repeat();
							}
						})								
					break;
					//вверх
					case 3:
					$.ajax({
							type: "POST",
							url: "http://task/",
							data: "id="+tid+"&type="+type+"&tcontrols=3&project="+project,
							cache: false,
							success: function (answer) {
								$("#output").html(answer); 								
							},
							error: function () {
								alert('Ошибка при отправке!');
								repeat();
							}
						})									
					break;	
					//вниз					
					case 4:
					$.ajax({
							type: "POST",
							url: "http://task/",
							data: "id="+tid+"&type="+type+"&tcontrols=4&project="+project,
							cache: false,
							success: function (answer) {
								$("#output").html(answer); 								
							},
							error: function () {
								alert('Ошибка при отправке!');
								repeat();
							}
						})				
					
					break;	
					case 5:
					$.ajax({
							type: "POST",
							url: "http://task/",
							data: "id="+tid+"&type="+type+"&tcontrols=5&project="+project,
							cache: false,
							success: function (answer) {
								$("#output").html(answer); 								
							},
							error: function () {
								alert('Ошибка при отправке!');
								repeat();
							}
						})				
					
					break;								
				}				
				return false;
				  
	}

		
		