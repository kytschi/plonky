/**
 * Plonky Javascript
 *
 * @package     Plonky\Javacript
 * @author 		Mike Welsh
 * @copyright   2023 Mike Welsh
 * @version     0.0.1
 *
 * Copyright 2023 Mike Welsh
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 *
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA  02110-1301, USA.
 */
namespace Plonky;

class Javascript
{
    public function build(array projects)
    {
        var key;
        echo "<script type='text/javascript'>
            try {
                var projects = " . json_encode(projects) . ";\n";

        let key = null;
        if (isset(_POST["project_key"])) {
            if (_POST["project_key"] != "") {
                let key = intval(_POST["project_key"]);
            }
        }
        echo "var project_key = " . (key === null ? "null" : key) . ";";

        let key = null;
        if (isset(_POST["collection_key"])) {
            if (_POST["collection_key"] != "") {
                let key = intval(_POST["collection_key"]);
            }
        }
        echo "var collection_key = " . (key === null ? "null" : key) . ";";

        let key = null;
        if (isset(_POST["collection_item_key"])) {
            if (_POST["collection_item_key"] != "") {
                let key = intval(_POST["collection_item_key"]);
            }
        }
        echo "var collection_item_key = " . (key === null ? "null" : key) . ";
            } catch (err) {
                showAlert('Failed to load the projects', 'error');
                console.log(err);
            }
            function send() {
                if (project_key === null) {
                    showAlert('Please select a project', 'error');
                    return;
                } else if (collection_key === null) {
                    showAlert('Please select a project collection', 'error');
                    return;
                } else if (collection_item_key === null) {
                    showAlert('Please select a project collection item', 'error');
                    return;
                }
                document.getElementById('send_request').value = 'go';
                document.getElementById('project_file').value = projects[project_key].file;
                document.getElementById('project_key').value = project_key;
                document.getElementById('collection_key').value = collection_key;
                document.getElementById('collection_item_key').value = collection_item_key;
                document.getElementById('save-form').submit();
            }
            function showAbout() {
                document.getElementById('about').style.display = 'block';
            }
            function uuid() {
                return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                );
            }
            function projectMarkUpdated() {
                document.getElementById('project-title-' + project_key).innerHTML = projects[project_key].name + '*';
            }
            function addRequestParam() {
                if (collection_key === null) {
                    showAlert('Please select a project request', 'error');
                    return;
                }

                var element = {
                    'id': uuid(),
                    'key': '',
                    'value': '',
                    'active': true
                };
                var html = createParam(element, 'params');
                document.getElementById('request-params').innerHTML += html;
                try {
                    projects[project_key].collections[collection_key].items[collection_item_key].params.push(element);
                } catch(err) {
                    projects[project_key].collections[collection_key].items[collection_item_key].params = [];
                    projects[project_key].collections[collection_key].items[collection_item_key].params.push(element);
                }
            }
            function addGlobal() {
                if (project_key === null) {
                    showAlert('Please select a project', 'error');
                    return;
                }

                var element = {
                    'id': uuid(),
                    'key': '',
                    'value': '',
                    'active': true
                };
                var html = createParam(element, 'globals');
                document.getElementById('request-globals').innerHTML += html;
                try {
                    projects[project_key].globals.push(element);
                } catch(err) {
                    projects[project_key].globals = [];
                    projects[project_key].globals.push(element);
                }
                projectMarkUpdated();
            }
            function createParam(element, source) {
                html = \"<div id='\" + element.id + \"' class='list-item'>\";
                    html += \"<input type='checkbox' class='list-checkbox'\" + (element.active ? \" checked='checked'\" : '') + \" data-id='\" + element.id + \"' data-source='\" + source + \"' onchange='updateParamActive(this)'/>\";
                    html += \"<input type='text' value='\" + element.key + \"' class='list-text' data-id='\" + element.id + \"' data-source='\" + source + \"' data-type='key' onkeyup='updateParam(this)'/>\";
                    html += \"<input type='text' value='\" + element.value + \"' class='list-text' data-id='\" + element.id + \"' data-source='\" + source + \"' data-type='value' onkeyup='updateParam(this)'/>\";
                    html += \"<span title='Delete the parameter' data-id='\" + element.id + \"' data-source='\" + source + \"' onclick='deleteParam(this)' \";
                    html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></span>\";
                html += '</div>';
                return html;
            }
            function deleteParam(element) {
                if (element === true) {
                    if (delete_param.dataset.source == 'params') {
                        projects[project_key].collections[collection_key].items[collection_item_key].params.forEach(function(item, key) {
                            if (item.id == delete_param.dataset.id) {
                                projects[project_key].collections[collection_key].items[collection_item_key].params.splice(key, 1);
                                return;
                            }
                        });
                    } else if (delete_param.dataset.source == 'globals') {
                        projects[project_key].globals.forEach(function(item, key) {
                            if (item.id == delete_param.dataset.id) {
                                projects[project_key].globals.splice(key, 1);
                                return;
                            }
                        });
                    }

                    delete_param = null;
                    document.getElementById('delete-param').style.display = 'none';
                    buildProjectsList();
                    projectMarkUpdated();
                    showAlert('Parameter has been deleted');
                    return;
                } else {
                    delete_param = element;
                    document.getElementById('delete-param').style.display = 'block';
                }
            }
            function updateRequest() {
                projects[project_key].collections[collection_key]['items'][collection_item_key].url = document.getElementById('request-url').value;
                projects[project_key].collections[collection_key]['items'][collection_item_key].type = document.getElementById('request-type').value;
                projectMarkUpdated();
            }
            function updateParam(element) {
                if (element.dataset.source == 'params') {
                    projects[project_key].collections[collection_key].items[collection_item_key].params.forEach(function(item) {
                        if (item.id == element.dataset.id) {
                            item[element.dataset.type] = element.value;
                            return;
                        }
                    });
                    projectMarkUpdated();
                    return;
                } else if (element.dataset.source == 'globals') {
                    projects[project_key].globals.forEach(function(item) {
                        if (item.id == element.dataset.id) {
                            item[element.dataset.type] = element.value;
                            return;
                        }
                    });
                    projectMarkUpdated();
                    return;
                }
            }
            function updateParamActive(element) {
                if (element.dataset.source == 'params') {
                    projects[project_key].collections[collection_key].items[collection_item_key].params.forEach(function(item) {
                        if (item.id == id) {
                            item.active = element.checked;
                            return;
                        }
                    });
                    projectMarkUpdated();
                    return;
                } else if (element.dataset.source == 'globals') {
                    projects[project_key].globals.forEach(function(item) {
                        if (item.id == element.dataset.id) {
                            item[element.dataset.type] = element.checked;
                            return;
                        }
                    });
                    projectMarkUpdated();
                    return;
                }
            }
            function editProject(key) {
                if (key === true) {
                    document.getElementById('edit-project').style.display = 'none';
                    projects[project_key].name = document.getElementById('project-name').value;
                    buildProjectsList();
                    projectMarkUpdated();
                    showAlert('Project updated, do not forget to save!');
                } else {
                    project_key = key;
                    document.getElementById('project-name').value = projects[project_key].name;
                    document.getElementById('edit-project').style.display = 'block';
                }
            }
            function deleteItem(key) {
                if (key === true) {
                    document.getElementById('delete-item').style.display = 'none';
                    projects[project_key].collections[collection_key]['items'].splice(collection_item_key, 1);
                    collection_item_key = null;
                    buildProjectsList();
                    projectMarkUpdated();
                    showAlert('Collection item has been deleted');
                } else {
                    collection_item_key = key;
                    document.getElementById('delete-item').style.display = 'block';
                }
            }
            function deleteCollection(key) {
                if (key === true) {
                    document.getElementById('delete-collection').style.display = 'none';
                    projects[project_key].collections.splice(collection_key, 1);
                    collection_key = null;
                    buildProjectsList();
                    projectMarkUpdated();
                    showAlert('Collection has been deleted');
                } else {
                    collection_key = key;
                    document.getElementById('delete-collection').style.display = 'block';
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
                document.getElementById('projects-json').value = JSON.stringify(projects);
                document.getElementById('send_request').value = '';
                document.getElementById('project_file').value = '';
                document.getElementById('project_key').value = project_key;
                document.getElementById('collection_key').value = collection_key;
                document.getElementById('collection_item_key').value = collection_item_key;
                document.getElementById('save-form').submit(); 
            }
            function showTab(tab, target='request') {
                var tabs = document.getElementsByClassName(target + '-tab');
                var tabs_content = document.getElementsByClassName(target + '-tab-content');
                for (var iLoop = 0; iLoop < tabs.length; iLoop++) {
                    tabs[iLoop].classList.remove('selected');
                    tabs_content[iLoop].style.display = 'none';
                }
                document.getElementById(target + '-tab-' + tab).classList.add('selected');
                document.getElementById(target + '-tab-content-' + tab).style.display = 'block';
            }
            function buildProjectsList() {
                var html = '';
                projects.forEach(function(project, key) {
                    if (!key && project_key === null) {
                        project_key = key;
                    }
                    html += \"<div id='project-\" + key + \"' class='project' onclick='selectProject(\" + key + \");'>\";
                        html += \"<div class='project-title\" + (!project_key ? ' selected' : '') + \"'>\";
                        html += \"<span id='project-title-\" + key + \"'>\" + project.name + '</span>';
                        html += \"<div title='Edit the project' onclick='editProject(\" + key + \")' \";
                        html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/></svg></div>\";
                        html += \"<div onclick='deleteProject(\" + key + \")' \";
                        html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>\";
                        html += '</div>';
                        html += \"<div class='project-collections'>\";
                        project.collections.forEach(function(collection, col_key) {
                            html += \"<div id='collection-\" + col_key + \"' class='project-collection' onclick='collection_key=\" + col_key + \"'>\";
                                html += \"<div class='project-collection-toolbar'>\";
                                    if (collection.items.length != 0) {
                                        html += \"<div onclick='growCollection(\" + col_key + \")' \";
                                        html += \"class='button-grow button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg></div>\";
                                        html += \"<div onclick='growCollection(\" + col_key + \")' \";
                                        html += \"class='button-shrink button hide'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z'/></svg></div>\";
                                    }
                                    html += \"<span onclick='growCollection(\" + col_key + \")' >\" + collection.name + '</span>';
                                    html += \"<div title='Edit the collection' onclick='editCollection(\" + col_key + \")' \";
                                    html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/></svg></div>\";
                                    html += \"<div onclick='deleteCollection(\" + col_key + \")' \";
                                    html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>\";
                                html += '</div>';
                                html += \"<div id='collection-items-\" + col_key + \"' class='project-collection-items'>\";
                                collection.items.forEach(function(item, item_key) {
                                    html += \"<div id='project-collection-item-\" + col_key + '-' + item_key + \"' class='project-collection-item' onclick='selectCollectionItem(\" + col_key + \", \" + item_key + \")'>\";
                                        html += \"<div class='title'>\";
                                            html += '<p>' + item.name + '</p>';
                                            html += '<span>' + item.type + '</span>';
                                        html += '</div>';
                                        html += \"<div onclick='deleteItem(\" + item_key + \")' \";
                                        html += \"class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>\";
                                    html += '</div>';
                                });
                                html += '</div>';
                            html += '</div>';
                        });
                        html += '</div>';
                    html += '</div>';
                });
                document.getElementById('projects-list').innerHTML = html;

                if (project_key !== null) {
                    selectProject(project_key);
                }

                if (collection_key !== null) {
                    growCollection(collection_key);
                }

                if (collection_item_key !== null) {
                    selectCollectionItem(collection_key, collection_item_key);
                }
            }
            function selectProject(key) {
                project_key = key;
                var html = \"\";
                try {
                    projects[key].globals.forEach(function(element, item_key) {
                        html += \"<div class='list-item'>\";
                            html += \"<input type='checkbox' class='list-checkbox'\" + (element.active ? \" checked='checked'\" : '') + \"\>\";
                            html += \"<input type='text' value='\" + element.key + \"' class='list-text'/>\";
                            html += \"<input type='text' value='\" + element.value + \"' class='list-text'/>\";
                        html += '</div>';
                    });
                } catch (err) {
                    // Do nothing, catching invalid json
                }
                document.getElementById('request-globals').innerHTML = html;
            }
            function selectCollectionItem(col_key, key) {
                var html = '';
                collection_key = col_key;
                collection_item_key = key;
                var item = projects[project_key].collections[collection_key].items[key];
                document.getElementById('request-name-info').innerHTML = item.name;
                document.getElementById('request-type-info').innerHTML = item.type;
                document.getElementById('request-type').value = item.type;
                document.getElementById('request-url').value = item.url;
                var elements = document.getElementsByClassName('project-collection-item');
                if (elements) {
                    for (var iLoop = 0; iLoop < elements.length; iLoop++) {
                        elements[iLoop].classList.remove('selected');
                    }
                }
                document.getElementById('project-collection-item-' + collection_key + '-' + key).classList.add('selected');
                try {
                    item.params.forEach(function(element, item_key) {
                        html += createParam(element, 'params');
                    });
                } catch (err) {
                    // Do nothing, catching invalid json
                }
                document.getElementById('request-params').innerHTML = html;
            }
            function growCollection(key) {
                var collection = document.getElementById('collection-' + key);
                collection.childNodes.forEach(function(child) {
                    if (child.className == 'project-collection-toolbar') {
                        child.childNodes.forEach(function(button) {
                            if (button.className) {
                                if (button.className.search('button-grow') != -1) {
                                    if (button.className.search('hide') != -1) {
                                        button.classList.remove('hide');
                                    } else {
                                        button.classList.add('hide');
                                        document.getElementById('collection-items-' + key).style.display = 'block';
                                    }
                                } else if (button.className.search('button-shrink') != -1) {
                                    if (button.className.search('hide') != -1) {
                                        button.classList.remove('hide');
                                    } else {
                                        button.classList.add('hide');
                                        document.getElementById('collection-items-' + key).style.display = 'none';
                                    }
                                }
                            }
                        });
                    }
                });
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
        </script>";
    }
}