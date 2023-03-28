<!DOCTYPE html><html lang='en'>
    <head>
        <style>
            html, body {
                background-color: #414141;
                color: #000;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14pt;
                height: 100vh;
                width: 100%;
                padding: 10px;
                margin: 0;
                overflow-x: hidden;
            }
            body {
                display: grid;
                grid-template-columns: 400px calc(100% - 460px);
                grid-template-rows: auto;
                grid-template-areas: 
                    'project'
                    'main';
                column-gap: 20px;
            }
            .alert {
                position: fixed;
                bottom: 30px;
                left: 50%;
                width: 33%;
                max-width: 500px;
                transform: translate(-50%, -50%);
                margin: 0 auto;
                display: grid;
                border-radius: 10px;
                background-color: #712CF9;
                padding: 20px;
                color: #fff;
                display: none;
                cursor: pointer;
            }
            #error {
                background-color: #ff3200;
            }
            #projects, main {
                height: 100vh;
                grid-template-columns: auto;
                grid-template-rows: minmax(100px, max-content);
                display: grid;
                background-color: #fff;
                overflow-x: hidden;
            }
            .project {
                margin-bottom: 20px;
            }
            .project-collections {
                border-bottom: 1px solid #531fba;
            }
            .project-collection {
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: auto;
            }
            .project-collection-toolbar {
                min-height: 30px;
                padding: 20px;
                border-top: 1px solid #531fba;
                cursor: pointer;
            }
            .project-collection-items {
                display: none;
                background-color: #f2edfc;
                min-height: 30px;
                font-size: 12pt;
                cursor: pointer;
            }
            .project-collection-item {
                min-height: 30px;
                padding: 20px;
                border-top: 1px solid #531fba;
            }
            .project-collection-toolbar span, .project-title span {
                float: left;
                width: 60%;
            }
            .project-collection-toolbar .button, .project-title .button {
                float: right;
                margin-left: 10px;
                cursor: pointer;
            }
            .selected {
                background-color: #9c6ff7;
            }
            .project-title {
                min-height: 30px;
                background-color: #9665f7;
                font-weight: bold;
                color: #fff;
                padding: 20px;
            }
            .toolbar {
                height: 110px;
                background-color: #712CF9;
                border-bottom: 1px solid #531fba;
            }
            .toolbar .button {
                width: 30px;
                height: 30px;
                padding: 15px;
                margin-top: 20px;
                margin-right: 20px;
                border: 3px solid #fff;
                border-radius: 50%;
                float: right;
                cursor: pointer;
            }
            .toolbar .button svg {
                fill: #fff;
                width: 100%;
                height: 100%;
            }
            .toolbar .title {
                float: left;       
                font-size: 20pt;
                font-weight: bold;
                margin: 20px;
                color: #fff;
            }
            .toolbar .title p, .project-collection-item .title p {
                padding: 0;
                margin: 0;
            }
            .toolbar .title span, .project-collection-item .title span {
                font-size: 10pt;
            }
            #quick-menu-button {                
                position: fixed;
                right: 30px;
                bottom: 30px;
            }
            #quick-menu {
                position: fixed;
                right: 30px;
                bottom: 120px;
                width: 80px;
                display: none;
            }
            #quick-menu .button, #quick-menu-button .button {
                background-color: #712CF9;
                height: 80px;
                width: 80px;
                border-radius: 50%;
                text-align: center;
                cursor: pointer;
            }
            #quick-menu .button {
                margin-bottom: 10px;
            }
            #quick-menu-button svg, #quick-menu svg {
                width: 30px;
                height: 30px;
                margin-top: 25px;
                fill: #fff;
            }
            .hide {
                display: none;
            }
            .popover {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100vh;
                background: rgb(0, 0, 0, 0.9);
            }
            .box {
                position: fixed;
                top: 30%;
                left: 50%;
                width: 33%;
                max-width: 500px;
                transform: translate(-50%, -50%);
                background-color: #fff;
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: auto;
            }
            .box-title {
                color: #fff;
                background-color: #712CF9;
                border-bottom: 1px solid #531fba;
                padding: 20px;
            }
            .box-content {
                padding: 20px;
            }
            .box-footer {
                padding: 20px;
            }
            .box-footer button {
                float: right;
                margin-left: 10px;
                background-color: #712CF9;
                color: #fff;
                border: 0;
                padding: 15px 20px;
                cursor: pointer;
            }
            .button-cancel {
                background-color: #ccc !important;
                color: #000 !important;
            }

            .input-group {
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: auto;
            }

            .input-group span {
                margin-bottom: 10px;
            }
            .input-group input {
                padding: 10px 15px;
            }
        </style>
    </head>
    <body>
        <?php
            $projects = [];
            $folder = getcwd() . "/../projects/";
            $files = scandir($folder);
            foreach ($files as $file) {
                if (strpos($file, ".json") !== false) {
                    $projects[] = json_decode(file_get_contents($folder . $file));
                }
            }     
        ?>        
        <div id='projects'>
            <div class='toolbar'>
                <div class='title'>Plonky</div>
            </div>
            <div id='projects-list'></div>
        </div>
        <main>
            <div class='toolbar'>
                <div class='title'>
                    <p id='request-name'>Request</p>
                    <span id='request-type'>GET</span>
                </div>
                <div id='add-collection' class='button' title='Fire the request off'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                        <path d='M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z'/>
                    </svg>
                </div>
            </div>
        </main>
        <div id='quick-menu'>
            <div class='button' title='Add a collection'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z'/>
                    <path d='M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z'/>
                </svg>
            </div>
            <div class='button' title='Add a request'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z'/>
                    <path d='M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z'/>
                </svg>
            </div>
            <div class='button' title='Add a project'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z'/>
                    <path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/>
                    <path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/>
                </svg>
            </div>
            <div class='button' title='Save' onclick='save()'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z'/>
                    <path d='M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z'/>
                </svg>
            </div>
        </div>
        <div id='quick-menu-button' onclick='showQuickMenu()'>
            <div class='button'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z'/>
                    <path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/>
                    <path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/>
                </svg>
            </div>
        </div>
        <div id='error' class='alert' onclick='hideAlert("error")'>            
            <div id='error-message'>ERROR</div>
        </div>
        <div id='info' class='alert' onclick='hideAlert()'>
            <div id='info-message'>INFO</div>
        </div>
        <div id='edit-project' class='popover hide'>
            <div class='box'>
                <div class='box-title'>Edit project</div>
                <div class='box-content'>
                    <div class='input-group'>
                        <span>Project name</span>
                        <input id='project-name' name='name' value=''>
                    </div>
                </div>
                <div class='box-footer'>
                    <button onclick='editProject(true)'>done</button>
                    <button onclick='cancel("edit-project")' class='button-cancel'>cancel</button>
                </div>
            </div>
        </div>
        <div id='delete-project' class='popover hide'>
            <div class='box'>
                <div class='box-title'>Delete project</div>
                <div class='box-content'>
                    Are you sure?
                </div>
                <div class='box-footer'>
                    <button onclick='deleteProject(true)'>yes</button>
                    <button onclick='cancel("delete-project")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <form id='save-form' method='post' class='hide'>
            <textarea id='projects-json'></textarea>
        </form>
        <script type='text/javascript'>
            try {
                var projects = <?= json_encode($projects); ?>;
                var project_key = null;
                var collection_key = null;
            } catch (err) {
                showAlert('Failed to load the projects', 'error');
                console.log(err);
            }
            function editProject(key) {
                if (key === true) {
                    document.getElementById('edit-project').style.display = 'none';
                    projects[project_key].name = document.getElementById('project-name').value;
                    project_key = null;
                    buildProjectsList();
                    showAlert('Project updated, don\'t forget to save!');
                } else {
                    project_key = key;
                    document.getElementById('project-name').value = projects[project_key].name;
                    document.getElementById('edit-project').style.display = 'block';
                }
            }
            function deleteProject(key) {
                if (key === true) {
                    document.getElementById('delete-project').style.display = 'none';
                    delete projects[project_key];
                    project_key = null;
                    buildProjectsList();
                    showAlert('Project has been deleted');
                } else {
                    project_key = key;
                    document.getElementById('delete-project').style.display = 'block';
                }
            }
            function cancel(id) {
                document.getElementById(id).style.display = 'none';
            }
            function save() {
                document.getElementById('save-form').submit(); 
            }
            function buildProjectsList() {
                var html = '';
                document.getElementById('projects-json').text = JSON.stringify(projects);
                projects.forEach(function(project, key) {
                    html += '<div id=\'project-' + key + '\' class=\'project\' onclick=\'project_key=' + key + '\'>';
                        html += '<div class=\'project-title\'>';
                        html += '<span>' + project.name + '</span>';
                        html += '<div onclick=\'editProject("' + key + '")\' class=\'button\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' viewBox=\'0 0 16 16\'><path d=\'M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\'/></svg></div>';
                        html += '<div onclick=\'deleteProject("' + key + '")\' class=\'button\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' viewBox=\'0 0 16 16\'><path d=\'M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\'/></svg></div>';
                        html += '</div>';
                        html += '<div class=\'project-collections\'>';
                        project.collections.forEach(function(collection, collection_key) {
                            html += '<div id=\'collection-' + collection_key + '\' class=\'project-collection\' onclick=\'collection_key=' + collection_key + '\'>';
                                html += '<div class=\'project-collection-toolbar\'>';
                                html += '<span>' + collection.name + '</span>';
                                html += '<div onclick=\'growCollection(\"' + collection_key + '\")\' class=\'button-grow button\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' viewBox=\'0 0 16 16\'><path fill-rule=\'evenodd\' d=\'M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z\'/></svg></div>';
                                html += '<div onclick=\'shrinkCollection(\"' + collection_key + '\")\' class=\'button-shrink button hide\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' viewBox=\'0 0 16 16\'><path fill-rule=\'evenodd\' d=\'M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z\'/></svg></div>';
                                html += '</div>';
                                html += '<div id=\'collection-items-' + collection_key + '\' class=\'project-collection-items\'>';
                                collection.items.forEach(function(item, item_key) {
                                    html += '<div class=\'project-collection-item\' onclick="selectCollectionItem(\'' + item_key + '\')">';
                                        html += '<div class=\'title\'>';
                                            html += '<p>' + item.name + '</p>';
                                            html += '<span>' + item.type + '</span>';
                                        html += '</div>';
                                        html += '<div onclick=\'deleteItem("' + item_key + '")\' class=\'button\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' viewBox=\'0 0 16 16\'><path d=\'M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\'/></svg></div>';
                                    html += '</div>';
                                });
                                html += '</div>';
                            html += '</div>';
                        });
                        html += '</div>';
                    html += '</div>';
                });
                document.getElementById('projects-list').innerHTML = html;
            }
            function selectCollectionItem(key) {
                document.getElementById('request-name').innerHTML = projects[key].collections[collection_key].items[key].name;
            }
            function growCollection(key) {
                var collection = document.getElementById('collection-' + key);
                collection.childNodes.forEach(function(child) {
                    if (child.className == 'project-collection-toolbar') {
                        child.childNodes.forEach(function(button) {
                            if (button.className) {
                                if (button.className.search('button-grow') != -1) {
                                    button.classList.add('hide');
                                } else if (button.className.search('button-shrink') != -1) {
                                    button.classList.remove('hide');
                                }
                            }
                        });
                    }
                });
                document.getElementById('collection-items-' + key).style.display = 'block';
            }
            function shrinkCollection(key) {    
                var collection = document.getElementById('collection-' + key);
                collection.childNodes.forEach(function(child) {
                    if (child.className == 'project-collection-toolbar') {
                        child.childNodes.forEach(function(button) {
                            if (button.className) {
                                if (button.className.search('button-shrink') != -1) {
                                    button.classList.add('hide');
                                } else if (button.className.search('button-grow') != -1) {
                                    button.classList.remove('hide');
                                }
                            }
                        });
                    }
                });            
                document.getElementById('collection-items-' + key).style.display = 'none';
            }
            function showQuickMenu() {
                if (document.getElementById('quick-menu').style.display == 'none') {
                    document.getElementById('quick-menu').style.display = 'block';
                } else {
                    document.getElementById('quick-menu').style.display = 'none';
                }
            }
            function hideAlert(type = 'info') {
                document.getElementById(type).style.display = 'none';
            }
            function showAlert(message, type = 'info') {
                document.getElementById(type + '-message').innerHTML = message;
                document.getElementById(type).style.display = 'block';
            }
            document.getElementById('quick-menu').style.display = 'none';
            buildProjectsList();
        </script>
    </body>
</html>