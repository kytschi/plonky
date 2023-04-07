/**
 * Plonky
 *
 * @package     Plonky\Plonky
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

use Plonky\Exceptions\Exception;
use Plonky\Gfx;
use Plonky\Style;

class Plonky
{
    private projects = [];
    private save_mode = false;
    private demo_mode = false;
    private projects_folder = "";

    private response = null;
    private headers = null;
    private saved = false;

    private gfx;
    private version = "0.0.2 alpha";

    public function __construct(array cfg = [])
	{
        var files, file, err, project;
        let project = new \stdClass();

        let this->gfx = new Gfx();

        define("VERSION", this->version);

        try {
            let this->projects_folder = getcwd() . "/";
            if (!isset(cfg["projects_folder"])) {
                let this->projects_folder = this->projects_folder . cfg["projects_folder"];
            } else {
                let this->projects_folder = this->projects_folder . "../projects/";
            }

            if (!is_dir(this->projects_folder)) {
                throw new Exception(
                    "Projects folder not found",
                    404
                );
            }

            if (array_key_exists("save_mode", cfg)) {
                if (cfg["save_mode"]) {
                    let this->save_mode = true;
                }
            }
            if (isset(_POST["projects_non_save_json"])) {
                if (!empty(_POST["projects_non_save_json"])) {
                    let this->projects = json_decode(_POST["projects_non_save_json"]);
                }
            }
            if (array_key_exists("demo_mode", cfg)) {
                if (cfg["demo_mode"]) {
                    let this->demo_mode = true;
                    let this->projects = null;
                }
            }

            if (empty(this->projects)) {
                let files = scandir(this->projects_folder);
                for file in files {
                    if (strpos(file, ".json") !== false) {
                        let project = json_decode(file_get_contents(this->projects_folder . file));
                        let project->file = file;
                        let this->projects[] = project;
                    }
                }
            }

            var send;
            let send = false;
            if (isset(_POST["send_request"])) {
                if (!empty(_POST["send_request"])) {
                    this->send(cfg);
                    let send = true;
                }
            }

            if (!send) {
                this->save();
            }
            this->build();
        } catch \Exception, err {
            throw new Exception(
				err->getMessage(),
				err->getCode()
			);
        }
    }

    private function build()
    {
        echo "<!DOCTYPE html><html lang='en'><head>";
        (new Style())->build();
        echo "</head><body><div id='mobile' class='popover hide'>
            <div class='box'>
                <div class='box-title'>
                    <div class='icon'>" . this->gfx->genTitle("Napoleon Complex") . "</div>
                </div>
                <div class='box-content'>
                    <div class='input-group'>
                        <p>Your screen size is too small for Plonky</p>
                    </div>
                </div>
            </div>
        </div><div id='projects'>
            <div class='toolbar'>
                <div class='icon' onclick='showAbout()'>" . this->gfx->genTitle("Plonky", "a drunken app") . "</div></div>
            <div id='projects-list'></div>";
            if (this->demo_mode) {
                echo "<div id='demo-mode'>IN DEMO MODE</div>";
            }
        echo "</div>
        <main>
            <div class='toolbar'>
                <div id='request-title' class='title'>
                    <p id='request-name-info'>Request</p>
                    <span id='request-type-info'>GET</span>
                </div>
                <button id='btn-send' class='button' name='send' title='Fire the request off' type='button' onclick='send()'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                        <path d='M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z'/>
                    </svg>
                </button>
            </div>
            <form id='save-form' method='post'>
                <div id='request-url-box'>
                    <select id='request-type' name='request_type' onchange='updateRequest()'>
                        <option value='GET'>GET</option>
                        <option value='POST'>POST</option>
                        <option value='PUT'>PUT</option>
                        <option value='PATCH'>PATCH</option>
                        <option value='DELETE'>DELETE</option>
                        <option value='COPY'>COPY</option>
                        <option value='HEAD'>HEAD</option>
                        <option value='OPTIONS'>OPTIONS</option>
                        <option value='LINK'>LINK</option>
                        <option value='UNLINK'>UNLINK</option>
                        <option value='PURGE'>PURGE</option>
                        <option value='LOCK'>LOCK</option>
                        <option value='UNLOCK'>UNLOCK</option>
                        <option value='PROPFIND'>PROPFIND</option>
                        <option value='VIEW'>VIEW</option>
                    </select>
                    <input id='request-url' name='request_url' onkeyup='updateRequest()'/>
                </div>
                <div id='request-tabs' class='tabs'>
                    <div id='request-tab-params' class='tab request-tab selected' onclick='showTab(\"params\")'>Params</div>
                    <div id='request-tab-body' class='tab request-tab' onclick='showTab(\"body\")'>Body</div>
                    <div id='request-tab-auth' class='tab request-tab' onclick='showTab(\"auth\")'>Auth</div>
                    <div id='request-tab-headers' class='tab request-tab' onclick='showTab(\"headers\")'>Headers</div>
                    <div id='request-tab-globals' class='tab request-tab' onclick='showTab(\"globals\")'>Globals</div>
                </div>
                <div id='request-tabs-content' class='tabs-content'>
                    <div id='request-tab-content-params' class='tab-content request-tab-content'>
                        <div class='tab-content-toolbar'>
                            <div class='button' title='Add request parameter' onclick='addRequestParam()'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z'/>
                                    <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z'/>
                                    <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z'/>
                                </svg>
                            </div>
                        </div>
                        <div class='content'>
                            <div id='request-params' class='list'>" . this->gfx->selectSomething() . "</div>
                        </div>
                    </div>
                    <div id='request-tab-content-auth' class='tab-content request-tab-content hide'>
                        <div class='content'>" . this->gfx->toDo() . "</div>
                    </div>
                    <div id='request-tab-content-headers' class='tab-content request-tab-content hide'>
                        <div class='content'>" . this->gfx->toDo() . "</div>
                    </div>
                    <div id='request-tab-content-body' class='tab-content request-tab-content hide'>
                    <div class='tab-content-toolbar'>
                            <select id='request-body-type' name='request_body_type' onchange='updateRequest()'>
                                <option value='form'>FORM</option>
                            </select>
                            <div class='button' title='Add request parameter' onclick='addRequestBody()'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z'/>
                                    <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z'/>
                                    <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z'/>
                                </svg>
                            </div>
                        </div>
                        <div class='content'><div id='request-body' class='list'>" . this->gfx->toDo() . "</div></div>
                    </div>
                    <div id='request-tab-content-globals' class='tab-content request-tab-content hide'>
                        <div class='tab-content-toolbar'>
                            <div class='button' title='Add request global' onclick='addGlobal()'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z'/>
                                    <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z'/>
                                    <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z'/>
                                </svg>
                            </div>
                        </div>
                        <div class='content'>
                            <div id='request-globals' class='list'>" . this->gfx->selectSomething() . "</div>
                        </div>
                    </div>
                </div>
                <textarea id='projects-save-json' name='projects_save_json' class='hide'></textarea>
                <textarea id='projects-non-save-json' name='projects_non_save_json' class='hide'></textarea>
                <input type='hidden' id='send_request' name='send_request' value=''>";
        var file;
        let file = "";
        if (isset(_POST["project_file"])) {
            if (_POST["project_file"] != "") {
                let file = _POST["project_file"];
            }
        }
        echo "<input type='hidden' id='project_file' name='project_file' value='" . file . "'>
                <input type='hidden' id='project_key' name='project_key' value=''>
                <input type='hidden' id='collection_key' name='collection_key' value=''>
                <input type='hidden' id='collection_item_key' name='collection_item_key' value=''>
            </form>
            <div id='response-tabs' class='tabs'>
                <div id='response-tab-response' class='tab response-tab selected' onclick='showTab(\"response\", \"response\")'>Response</div>
                <div id='response-tab-headers' class='tab response-tab' onclick='showTab(\"headers\", \"response\")'>Headers</div>
            </div>
            <div id='response-tabs-content' class='tabs-content'>
                <div id='response-tab-content-response' class='tab-content response-tab-content'>
                    <div class='content'>" . this->outputResponse() . "</div>
                </div>
                <div id='response-tab-content-headers' class='tab-content response-tab-content hide'>
                    <div class='content'>" . this->outputHeaders() . "</div>
                </div>
            </div>
        </main>
        <div id='quick-menu'>
            <div class='button' title='Add a request'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z'/>
                    <path d='M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z'/>
                </svg>
            </div>
            <div class='button' title='Add a collection'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                    <path d='m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z'/>
                    <path d='M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z'/>
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
        <div id='error' class='alert' onclick='hideAlert(\"error\")'>
            <div class='row'>
                <div class='col'>" . this->gfx->plonkyIcon() . "</div>
                <div class='col text'>
                    <div class='title'>*HICCUP*</div>
                    <div id='error-message'>INFO</div>
                </div>
            </div>
        </div>
        <div id='info' class='alert' onclick='hideAlert()'>
            <div class='row'>
                <div class='col'>" . this->gfx->plonkyIcon() . "</div>
                <div class='col text'>
                    <div class='title'>MEEEEEOW!</div>
                    <div id='info-message'>INFO</div>
                </div>
            </div>
        </div>
        <div id='about' class='popover hide'>
            <div class='box'>
                <div class='box-title'>
                    <div class='icon'>" . this->gfx->genTitle("About Plonky", this->version) . "</div>
                </div>
                <div class='box-content'>
                    <div class='row'>
                        <div id='og-plonky' class='col'>
                            " . this->gfx->ogPlonky() . "
                            <p>For mam, the original plonky</p>
                        </div>
                        <div class='col'>
                            <p>
                                <span>
                                    By Mike Welsh<br/>
                                    <a href='mailto:hello@kytschi.com'>hello@kytschi.com</a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class='box-footer'>
                    <button onclick='cancel(\"about\")'>done</button>
                </div>
            </div>
        </div>
        <div id='edit-project' class='popover hide'>
            <div class='box'>
                <div class='box-title'><div class='icon'>" . this->gfx->genTitle("Edit Project") . "</div></div>
                <div class='box-content'>
                    <div class='input-group'>
                        <span>Project name</span>
                        <input id='project-name' name='name' value=''>
                    </div>
                </div>
                <div class='box-footer'>
                    <button onclick='editProject(true)'>done</button>
                    <button onclick='cancel(\"edit-project\")' class='button-cancel'>cancel</button>
                </div>
            </div>
        </div>
        <div id='delete-project' class='popover hide'>
            <div class='box'>
                <div class='box-title'><div class='icon'>" . this->gfx->genTitle("Delete Project?") . "</div></div>
                <div class='box-content'>" . this->gfx->genDanger() . "</div>
                <div class='box-footer'>
                    <button onclick='deleteProject(true)'>yes</button>
                    <button onclick='cancel(\"delete-project\")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <div id='delete-param' class='popover hide'>
            <div class='box'>
                <div class='box-title'><div class='icon'>" . this->gfx->genTitle("Delete Parameter?") . "</div></div>
                <div class='box-content'>" . this->gfx->genDanger() . "</div>
                <div class='box-footer'>
                    <button onclick='deleteParam(true)'>yes</button>
                    <button onclick='cancel(\"delete-param\")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <div id='delete-collection' class='popover hide'>
            <div class='box'>
                <div class='box-title'><div class='icon'>" . this->gfx->genTitle("Delete Collection?") . "</div></div>
                <div class='box-content'>" . this->gfx->genDanger() . "</div>
                <div class='box-footer'>
                    <button onclick='deleteCollection(true)'>yes</button>
                    <button onclick='cancel(\"delete-collection\")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <div id='delete-item' class='popover hide'>
            <div class='box'>
                <div class='box-title'><div class='icon'>" . this->gfx->genTitle("Delete Collection Request?") . "</div></div>
                <div class='box-content'>" . this->gfx->genDanger() . "</div>
                <div class='box-footer'>
                    <button onclick='deleteItem(true)'>yes</button>
                    <button onclick='cancel(\"delete-item\")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>";
        (new Javascript())->build(this->projects);
        if (this->saved) {
            if (!this->save_mode) {
                echo "<script type='text/javascript'>showAlert('Save mode disabled', 'error');</script>";
            } else {
                echo "<script type='text/javascript'>showAlert('All successfully saved');</script>";
            }
        }
        echo "</body></html>";
    }

    private function save()
    {
        if (isset(_POST["projects_save_json"]) && this->save_mode) {
            var projects, iLoop, file;
            let projects = json_decode(_POST["projects_save_json"]);
            if (empty(projects)) {
                throw new Exception("Failed to decode for saving");
            }

            let iLoop = 0;
            while(iLoop < count(projects)) {
                let file = this->projects_folder . projects[iLoop]->file;
                unset(projects[iLoop]->file);
                file_put_contents(file, json_encode(projects[iLoop]));
                let iLoop = iLoop + 1;
            }
            //header("location: ");
        }

        let this->saved = true;
    }

    private function bracketCheck(string str) {
        if (substr(str, 0, 1) != "{") {
            let str = "{" . str;
        }
        if (substr(str, strlen(str) - 1, 1) != "}") {
            let str = str . "}";
        }
        return str;
    }

    private function outputHeaders()
    {
        if (this->headers) {
            return "<pre id='response-headers'>". this->headers . "</pre>";
        } else {
            return this->gfx->selectSomething();
        }        
    }

    private function outputResponse()
    {
        if (this->response) {
            var html;
            let html = "<pre id='response-response'></pre>";
            let html = html . "<script type='text/javascript'>document.getElementById('response-response').innerHTML = JSON.stringify(" .  json_encode(this->response) . ", null, '\t');</script>";
            return html;
        } else {
            return this->gfx->selectSomething();
        }        
    }

    private function send(array cfg = [])
    {
        if (empty(_POST["projects_non_save_json"])) {
            throw new Exception("Failed process request due to no project data");
        }

        var project, url, iLoop, request, response, curl, ssl, info;
        
        let project = this->projects[_POST["project_key"]];
        
        if (empty(project->collections[_POST["collection_key"]])) {
            throw new Exception("Failed process request");
        } elseif (empty(project->collections[_POST["collection_key"]]->items[_POST["collection_item_key"]])) {
            throw new Exception("Failed process request");
        }

        let request = project->collections[_POST["collection_key"]]->items[_POST["collection_item_key"]];
        if (empty(request)) {
            throw new Exception("Project request not found");
        }

        let url = request->url;
        let iLoop = 0;
        while (iLoop < count(project->globals)) {
            if (project->globals[iLoop]->active) {
                let url = str_replace(
                    this->bracketCheck(project->globals[iLoop]->key),
                    project->globals[iLoop]->value,
                    url
                );
            }
            let iLoop = iLoop + 1;
        }

        if (!empty(request->params)) {
            let iLoop = 0;
            while (iLoop < count(request->params)) {
                if (request->params[iLoop]->active) {
                    let url = str_replace(
                        this->bracketCheck(request->params[iLoop]->key),
                        request->params[iLoop]->value,
                        url
                    );
                }
                let iLoop = iLoop + 1;
            }
        }

        let curl = curl_init();

        curl_setopt(curl, CURLOPT_URL, url);
        curl_setopt(curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(curl, CURLINFO_HEADER_OUT, 1);

        let ssl = true;
        if (array_key_exists("ssl_validation", cfg)) {
            if (!cfg["ssl_validation"]) {
                let ssl = false;
            }
        }

        if (!ssl) {
            curl_setopt(curl, CURLOPT_SSL_VERIFYSTATUS, 0);
            curl_setopt(curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt(curl, CURLOPT_SSL_VERIFYPEER, 0);
        }

        if (strtoupper(request->type) == "POST") {
            curl_setopt(curl, CURLOPT_POST, 1);
        } else {
            curl_setopt(curl, CURLOPT_CUSTOMREQUEST, strtoupper(request->type));
        }

        if (strtoupper(request->body_type) == "FORM") {
            var form_data;
            let form_data = [];

            let iLoop = 0;
            while (iLoop < count(request->body)) {
                let form_data[request->body[iLoop]->key] = request->body[iLoop]->value;
                let iLoop = iLoop + 1;
            }

            //curl_setopt(curl, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
            curl_setopt(curl, CURLOPT_POSTFIELDS, form_data);
        } elseif (strtoupper(request->body_type) == "JSON") {
            curl_setopt(curl, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        }
    
        let response = curl_exec(curl);
        // Decode if its json, catch if not.
        try {
            let this->response = json_decode(response);
        } catch \Exception {
            let this->response = response;
        }
        let info = curl_getinfo(curl);

        if (!this->response) {
            let response = new \stdClass();
            let response->copyright = "(c)" . date("Y") . " Kytschi";
            let response->website = "https://kytschi.com";
            let response->verion = this->version;
            let response->code = info["http_code"];
            let response->message = "No response";
            let response->query = url;
            let response->data = [];
            let this->response = response;
            let this->headers = "No headers";
        } else {
            let this->headers = info["request_header"];
        }

        curl_close(curl);
    }
}