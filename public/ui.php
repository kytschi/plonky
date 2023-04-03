<!DOCTYPE html><html lang='en'>
    <head>
        <style>
            html, body {
                background-color: #2F2F2F;
                color: #fff;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14pt;
                height: 100vh;
                width: 100%;
                margin: 0;
                overflow: hidden;
            }
            html {
                padding: 20px;
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
                background-color: #008000;
                padding: 20px;
                color: #fff;
                display: none;
                cursor: pointer;
            }
            body {
                display: grid;
                width: calc(100% - 40px);
                height: calc(100vh - 40px);
                grid-template-columns: 400px calc(100% - 440px);
                grid-template-rows: auto;
                grid-template-areas: 
                    'project'
                    'main';
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            }
            #error {
                background-color: #ff3200;
            }
            #projects {
                background-color: #2F2F2F;
                border-right: 1px solid #2B2B2B;
                overflow-y: scroll;
                padding-bottom: 110px;
            }
            #projects .toolbar {
                position: absolute;
                float: left;
                width: 400px;
            }
            #projects-list {
                margin-top: 110px;
                grid-template-columns: auto;
                grid-template-rows: minmax(100px, max-content);
                display: grid;
            }
            main {
                height: 100vh;
                width: 100%;
                overflow-x: hidden;
                padding: 20px;
            }
            .project {
                margin-bottom: 20px;
            }
            .project-collection {
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: max-content;
                background-color: #363838;
                border-top: 1px solid #2B2B2B;
            }
            .project-collection-toolbar {
                min-height: 30px;
                padding: 20px;
            }
            .project-collection-items {
                display: none;
                font-size: 12pt;
                cursor: pointer;
                background-color: #2F2F2F;
            }
            .project-collection-item {
                min-height: 30px;
                padding: 20px;
                border-bottom: 1px solid #2B2B2B;
                border-left: 1px solid #2B2B2B;
                border-right: 1px solid #2B2B2B;
            }
            .project-collection-item .title {
                float: left;
            }
            .project-collection-item .title span {
                color: #20AB61;
            }
            .project-collection-toolbar span, .project-title span {
                float: left;
                width: 60%;
            }
            .project-collection-toolbar span {
                cursor: pointer;
            }
            .project-collection-toolbar .button, .project-title .button, .project-collection-item .button {
                float: right;
                margin-left: 10px;
                cursor: pointer;
            }
            .project-title {
                min-height: 30px;
                font-weight: bold;
                color: #fff;
                padding: 20px;
            }
            .toolbar {
                height: 110px;
                background-color: #2F2F2F;
            }
            .toolbar .button {
                border: 0;
                width: 80px;
                height: 80px;                
                text-align: center;
                margin-top: 5px;                
                background-color: #008000 !important;
                border-radius: 50%;
                float: right;
                box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                cursor: pointer;                
            }
            .toolbar .button svg {
                fill: #fff;
                width: 45px;
                height: 45px;
                margin-left: 5px;
                margin-top: 2px;
            }
            .toolbar .title {
                float: left;       
                font-size: 20pt;
                font-weight: bold;
                margin: 20px;
                color: #fff;
                line-height:15pt;
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
                background-color: #008000;
                height: 80px;
                width: 80px;
                border-radius: 50%;
                text-align: center;
                cursor: pointer;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
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
                background-color: #2F2F2F;
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: auto;
            }
            .box-title {
                color: #fff;
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
                background-color: #008000;
                color: #fff;
                border: 0;
                padding: 15px 20px;
                cursor: pointer;
            }
            .button-cancel {
                background-color: #ccc !important;
                color: #000 !important;
            }
            input, select {
                background-color: #3D3C3C;
                color: #fff;
                border: 0;
                padding: 10px;
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
            #request-url-box {
                display: grid;
                grid-template-columns: 100px calc(100% - 120px);
                grid-template-rows: 50px;
                grid-template-areas: 
                    'request-type'
                    'request-url';
                column-gap: 20px;
                padding-bottom: 20px;
                height: 50px;
            }
            #request-type-info {
                color: #20AB61;
            }
            .tabs {
                background-color: #3D3C3C;
                color: #fff;
                height: 60px;
                overflow-x: hidden;
                float: left;
                width: 100%;
                overflow: hidden;
            }
            .tab {
                float: left;
                padding: 20px;
                margin-right: 20px;
                cursor: pointer;
            }
            .tabs-content {
                float: left;
                width: 100%;
                display: grid;
                grid-template-columns: auto;
                grid-template-rows: max-content;
                margin-bottom: 20px;
            }
            .tab-content {
                float: left;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            .list {
                float: left;
                width: calc(100% - 40px);
                height: 100%;
                padding: 0 20px 0 20px;
                background-color: #464746;
                border-bottom: 1px solid #2B2B2B;
                border-left: 1px solid #2B2B2B;
                border-right: 1px solid #2B2B2B;
            }
            .list-item {
                display: grid;
                grid-template-columns: 30px calc(50% - 35px) calc(50% - 35px);
                grid-template-rows: 50px;
                grid-template-areas: 
                    '.list-checkbox'
                    '.list-text'
                    '.list-text';
                column-gap: 20px;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .tab-content-toolbar {
                float: left;
                width: 100%;
                height: 100%;
                height: 60px;
                background-color: #008000 !important;
            }
            .tab-content-toolbar .button {
                width: 30px;
                height: 30px;
                margin-top: 13px;
                margin-right: 20px;
                float: right;
                cursor: pointer;
            }
            .tab-content-toolbar .button svg {
                fill: #fff;
                width: 100%;
                height: 100%;
            }
            .selected {
                background-color: #008000 !important;
            }
            .project-collection-item.selected {
                background-color: #1f4213 !important;
            }
            .button-grow, .button-shrink  {
                float: left !important;
                margin-right: 10px;
                margin-left: 0 !important;
            }
            .icon {
                width: 100%;
                padding: 10px;
                font-size: 20pt;
                font-weight: bold;
                color: #fff;
                line-height:15pt;
            }
            .icon img, .icon span {
                float: left;
            }
            .icon span {
                margin: 30px;
            }
            .icon img {
                width: 80px;
                height: 80px;
                fill: #fff;
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
                <div class='icon'>
                    <img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAMAAABrrFhUAAADAFBMVEVHcEyYLGEAAACWQ3aXLGGYLGGXK2AAAABqOWxwPl2ZS3OYLGEAAAAAAACYLGGYKmIAAACPKVsAAACYK2ERCA6ZLGGXK2AAAACYLGEAAAAAAACYLWCYLGFTcJhTcJiYLGGZLGEAAACZK2GYK2GYLGEnDBpXcpeXK2BTcJhSb5eYLGHBdYtTcJiYLGGXLGFTb5d5I01Tb5eYLGGYLGGbMGViHD6Pj488ESaYLGFTb5dVcJdxIEhNFjGLKFlUb5hLZYmYLGGJJ1dYc5eDJVR3THuYK2Gtf4yPj4+GJlWPj49bGjoAAABScJhTcJg+VHGPj4/eYodqH0OYLGGYLGB9JFCPj4+Pj49Tb5gwQViBJVJWbJWPj4/eY4ePj48fKjmPj49nHULeYoePj49EXH3eYofeYoffYobeYoffYojeYodHX4LeYojfYYeONmneYofeYofeYofdYodsWIWYLGHeYof/obSetthTcJiPj4/a2tra6v////+bL2OaLWLPVn/+n7PLU3ykNWjbX4XSWYDETnm4RXKhNGbdYYbHUHudMGS1QnGqOmunN2m+SXafMWWtPGz8nLC7R3TgZIjWW4PhZ4uwPm7dYofcYIbZXYT6l62yQG/sfJrxhqH2j6fjao3nc5PqeJfvgZ7lb5C8vLyMpcibs9TBTHj0i6T4k6qkOmtgfKOVjpDYdJRphav49feEnsKdq83FX4V9lrvQ4fjhf5zIaYpYdZ2xsbHX19friqSUrc+jo6OVnqzQa45qfJVjdpbFxcVbeKB1j7W90eyqqqrOzs6bNWirweCpP27wkKiyS3h2gpPDhKRnYoycPW9tiK7mhaGuRXNxjLHz7/G7dZiYmJhkgKekR3bUZIjzlazv5+vp4OSfZI6EZY62yueSl56dnsSenp7as8a4ZozHl7Xgvs+XL2PG2fLmy9h3bpa7U32VT3+YqLyqgIxdbJWCiJHLW4KXcZuLjrWwXYbHuNaUg6yJOm3U2PDPyeTEqMmaj7e6wd+sZpG0RXLaAGAAF2v+TFR0AAABAHRSTlMA/CgLLfjzTAIGD8g9IrIVG+I32lNC7RK9C0Yl5vKG03subUqiXRkdoeZlHblejNqt+XSbOIxMaYMrZZ921XLRW882wf1SLWnI9oQxyVeg2nSVk1a1gZtGgLxMuUzqZ6qQ0si0qLGWhp3gv8nU/ebZ2tWu//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8o9RGlbwAAIABJREFUeNrsW1tMVNcadsIlIybwQCAkIBIhIigSsA/oAzFGfbIJ0QcT44uJlzZtTs/Jno3JODdgBoFhGGaAkWGAmSEItEE9yrGJvjSVBE4bpK2SYr3lxAtqTIyXalvbk5y19lpr77WvsznJlkmc/4HM7Nl7s/9v/f/339ZetSolKUlJSlKSkpSkJCUpSUlKklPy6rILtlalfajq789lGBPDMPlVH6T65dkML1s+ROvPZygpTZKnSqvfXF1Rsbn4QNb/e4esTXt0uXSlidafyTUng/rmDdUniFRv3L5t2Q+16fg/LED+fnxTojNrGYnsTgoD2HxCJGuXZwpZn4QsWELHtc2gkujd5Gtr5T6sSQoA1p6Qi25TOPSphZLPtYwgD9u/PXDKYmlDnwuTAQDoAVevXDl//Su5KWxIpH/IIpIj6qfmFCGd2x2ctSATqEsGDigGyn59phHIvcbzZ79elil8+sXhv4kQUDeBAqR/Vws60YdoMBksYAP0gasQgGmrdWp6VskUDqqYAtR3UwOFQYPaf6nC698cj3In9qDv5clgAvVQyysQASsnAITRi8sxhdUNhwkAx9RCLXIA+00nG0dnNnEHKpPBBFZXAAXPQgAeW4kAEK4sxxQOHQlpWkAdWvAXTpYA4OEOZCdFHPgYajcKAJi1UgIROaPfFNIOHfvss2MqgTAnk1PXG2ZZNoYAcHBHMpMiF1q1Fyj2FVR4SgIAJzpNQUuVfcgAIkB/dhgBcNrGHUpPCgB2Qq0uwjhAATDbSImyKWzQ62TIAALAAdhuQhde7tiO5CgHNpJQqAYANoWrYlOo2a7v9rsRA8ahAcQJAIgEtiYHAHwofKwFgNwUarbpun22YADEA0gymBzZ8KpVxTgUziYCQGIKxbrKzUyBASb4lAFlAvlJAgAfCgUavNeoKWdGz+oFYAenqr8bAhARkibEgsnSGiOh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'/>
                    <span>Plonky</span>
                </div>
            </div>
            <div id='projects-list'></div>
        </div>
        <main>
            <div class='toolbar'>
                <div class='title'>
                    <p id='request-name-info'>Request</p>
                    <span id='request-type-info'>GET</span>
                </div>
                <button class='button' name='send' title='Fire the request off' type='submit'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'>
                        <path d='M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z'/>
                    </svg>
                </button>
            </div>
            <form id='save-form' method='post'>
                <div id='request-url-box'>
                    <select id='request-type' name='request_type'>
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
                    <input id='request-url' name='request_url'/>
                </div>
                <div id='request-tabs' class='tabs'>
                    <div id='request-tab-params' class='tab request-tab selected' onclick='showTab("params")'>Params</div>
                    <div id='request-tab-auth' class='tab request-tab' onclick='showTab("auth")'>Auth</div>
                    <div id='request-tab-headers' class='tab request-tab' onclick='showTab("headers")'>Headers</div>
                    <div id='request-tab-body' class='tab request-tab' onclick='showTab("body")'>Body</div>
                    <div id='request-tab-globals' class='tab request-tab' onclick='showTab("globals")'>Globals</div>
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
                        <div id='request-params' class='list'></div>
                    </div>
                    <div id='request-tab-content-auth' class='tab-content request-tab-content hide'>
                        <p>To come</p>
                    </div>
                    <div id='request-tab-content-headers' class='tab-content request-tab-content hide'>
                        <p>To come</p>
                    </div>
                    <div id='request-tab-content-body' class='tab-content request-tab-content hide'>
                        <p>To come</p>
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
                        <div id='request-globals' class='list'></div>
                    </div>
                </div>
                <textarea id='projects-json' class='hide'></textarea>
            </form>
            <div id='response-tabs' class='tabs'>
                <div id='response-tab-response' class='tab response-tab selected' onclick='showTab("response", "response")'>Response</div>
                <div id='response-tab-headers' class='tab response-tab' onclick='showTab("headers", "response")'>Headers</div>
            </div>
            <div id='response-tabs-content' class='tabs-content'>
                <div id='response-tab-content-response' class='tab-content response-tab-content'>
                    <p>To come</p>
                </div>
                <div id='response-tab-content-headers' class='tab-content response-tab-content hide'>
                    <p>To come</p>
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
        <div id='delete-collection' class='popover hide'>
            <div class='box'>
                <div class='box-title'>Delete collection</div>
                <div class='box-content'>
                    Are you sure?
                </div>
                <div class='box-footer'>
                    <button onclick='deleteCollection(true)'>yes</button>
                    <button onclick='cancel("delete-collection")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <div id='delete-item' class='popover hide'>
            <div class='box'>
                <div class='box-title'>Delete collection request</div>
                <div class='box-content'>
                    Are you sure?
                </div>
                <div class='box-footer'>
                    <button onclick='deleteItem(true)'>yes</button>
                    <button onclick='cancel("delete-item")' class='button-cancel'>no</button>
                </div>
            </div>
        </div>
        <script type='text/javascript'>
            try {
                var projects = <?= json_encode($projects); ?>;
                var project_key = null;
                var collection_key = null;
                var collection_item_key = null;
            } catch (err) {
                showAlert('Failed to load the projects', 'error');
                console.log(err);
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
                var html = createParam(element);
                document.getElementById('request-params').innerHTML += html;
                try {
                    projects[project_key].collections[collection_key].items[collection_item_key].params.push(element);
                } catch(err) {
                    projects[project_key].collections[collection_key].items[collection_item_key].params = [];
                    projects[project_key].collections[collection_key].items[collection_item_key].params.push(element);
                }
                document.getElementById('projects-json').text = JSON.stringify(projects);
                projectMarkUpdated();
            }
            function addGlobal() {

            }
            function createParam(element) {
                html = "<div id='" + element.id + "' class='list-item'>";
                    html += "<input type='checkbox' class='list-checkbox'" + (element.active ? " checked='checked'" : '') + "/>";
                    html += "<input type='text' value='" + element.key + "' class='list-text'/>";
                    html += "<input type='text' value='" + element.value + "' class='list-text'/>";
                html += '</div>';
                return html;
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
                document.getElementById('projects-json').text = JSON.stringify(projects);
                projects.forEach(function(project, key) {
                    if (!key && project_key === null) {
                        project_key = key;
                    }
                    html += "<div id='project-" + key + "' class='project' onclick='selectProject(" + key + ");'>";
                        html += "<div class='project-title" + (!project_key ? ' selected' : '') + "'>";
                        html += "<span id='project-title-" + key + "'>" + project.name + '</span>';
                        html += "<div onclick='editProject(" + key + ")' ";
                        html += "class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/></svg></div>";
                        html += "<div onclick='deleteProject(" + key + ")' ";
                        html += "class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>";
                        html += '</div>';
                        html += "<div class='project-collections'>";
                        project.collections.forEach(function(collection, col_key) {
                            html += "<div id='collection-" + col_key + "' class='project-collection' onclick='collection_key=" + col_key + "'>";
                                html += "<div class='project-collection-toolbar'>";
                                    if (collection.items.length != 0) {
                                        html += "<div onclick='growCollection(" + col_key + ")' ";
                                        html += "class='button-grow button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg></div>";
                                        html += "<div onclick='growCollection(" + col_key + ")' ";
                                        html += "class='button-shrink button hide'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z'/></svg></div>";
                                    }
                                    html += "<span onclick='growCollection(" + col_key + ")' >" + collection.name + '</span>';
                                    html += "<div onclick='deleteCollection(" + col_key + ")' ";
                                    html += "class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>";
                                html += '</div>';
                                html += "<div id='collection-items-" + col_key + "' class='project-collection-items'>";
                                collection.items.forEach(function(item, item_key) {
                                    html += "<div id='project-collection-item-" + col_key + '-' + item_key + "' class='project-collection-item' onclick='selectCollectionItem(" + item_key + ")'>";
                                        html += "<div class='title'>";
                                            html += '<p>' + item.name + '</p>';
                                            html += '<span>' + item.type + '</span>';
                                        html += '</div>';
                                        html += "<div onclick='deleteItem(" + item_key + ")' ";
                                        html += "class='button'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\'/><path fill-rule=\'evenodd\' d=\'M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></div>";
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
            }
            function selectProject(key) {
                project_key = key;
                var html = "";
                try {
                    projects[key].globals.forEach(function(element, item_key) {
                        html += createParam(element);
                    });
                } catch (err) {
                    // Do nothing
                }
                document.getElementById('request-globals').innerHTML = html;
            }
            function selectCollectionItem(key) {
                var html = "";
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
                        html += createParam(element);
                    });
                } catch (err) {
                    // Do nothing
                    console.log(err);
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
        </script>
    </body>
</html>