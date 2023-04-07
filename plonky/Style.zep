/**
 * Plonky style builder
 *
 * @package     Plonky\Style
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

class Style
{
    public function build()
    {
        echo "<style>
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
        a {
            text-decoration: none;
            color: #fff;
        }
        .alert {
            position: fixed;
            bottom: 30px;
            left: 50%;
            width: 50%;
            max-width: 700px;
            transform: translate(-50%, -50%);
            margin: 0 auto;
            display: grid;
            border-radius: 10px;
            background-color: #DE6287;
            padding: 20px;
            color: #fff;
            display: none;
            cursor: pointer;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        .alert img {
            max-height: 80px;
            margin-right: 20px;
        }
        .alert .text {
            font-size: 18pt;
            vertical-align: middle;
        }
        .alert .title {
            color: #95295F;
            font-weight: bold;
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
            background-color: #95295F;
        }
        #error .title {
            color: #DE6287;
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
            margin-top: 130px;
            grid-template-columns: auto;
            grid-template-rows: minmax(100px, max-content);
            display: grid;
        }
        main {
            height: calc(100% - 20px);
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
            color: #DE6287;
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
            background-color: #DE6287 !important;
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
            right: 35px;
            bottom: 120px;
            width: 80px;
            display: none;
        }
        #btn-send {
            position: fixed;
            right: 35px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        #quick-menu .button, #quick-menu-button .button {
            background-color: #DE6287;
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
        #quick-menu .button:hover, #quick-menu-button .button:hover, #btn-send:hover {
            background-color: #95295F !important;
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
            top: 50%;
            left: 50%;
            width: 50%;
            max-width: 700px;
            transform: translate(-50%, -50%);
            background-color: #2F2F2F;
            display: grid;
            grid-template-columns: auto;
            grid-template-rows: auto;
        }
        .box-title {
            color: #fff;
            padding: 0 20px 20px 20px;
            background-color: #DE6287;
        }
        .box-content {
            padding: 20px;
            background-color: #464746;
        }
        .box-footer {
            padding: 20px;
        }
        .box-footer button {
            float: right;
            margin-left: 10px;
            background-color: #DE6287;
            color: #fff;
            border: 0;
            padding: 15px 20px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
        }
        .button-cancel {
            background: none !important;
            color: #fff !important;
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
        #request-type-info, #projects .toolbar small {
            color: #FFA1B4;
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
            width: 100%;
            height: 100%;
        }
        .request-tab-content .content, .response-tab-content .content {
            padding: 0 20px 0 20px;
            background-color: #464746;
            border-bottom: 1px solid #2B2B2B;
            border-left: 1px solid #2B2B2B;
            border-right: 1px solid #2B2B2B;
            float: left;
            width: calc(100% - 40px);
            height: 100%;
        }      
        .list-item {
            display: grid;
            grid-template-columns: 30px calc(50% - 55px) calc(50% - 55px) 20px;
            grid-template-rows: 50px;
            grid-template-areas: 
                '.list-checkbox'
                '.list-text'
                '.list-text'
                '.button';
            column-gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .list-item .button {
            margin-top: 10px;
            cursor: pointer;
        }
        .tab-content-toolbar {
            float: left;
            width: 100%;
            height: 100%;
            height: 60px;
            background-color: #DE6287 !important;
        }
        .tab-content-toolbar .button {
            width: 30px;
            height: 30px;
            margin-top: 13px;
            margin-right: 20px;
            float: right;
            cursor: pointer;
        }
        .tab-content-toolbar select {
            margin-top: 13px;
            margin-left: 20px;
            float: left;
            cursor: pointer;
        }
        .tab-content-toolbar .button svg {
            fill: #fff;
            width: 100%;
            height: 100%;
        }
        .selected {
            background-color: #DE6287 !important;
        }
        .project-collection-item.selected {
            background-color: #A53468 !important;
        }
        .project-collection-item.selected span {
            color: #FFA1B4 !important;
        }
        .button-grow, .button-shrink  {
            float: left !important;
            margin-right: 10px;
            margin-left: 0 !important;
        }
        .danger {
            color: #DE6287;
        }
        pre {
            color: #fff;
            font-weight: bold;
        }
        .icon {
            width: 100%;
            padding: 10px;
            font-size: 20pt;
            font-weight: bold;
            color: #fff;
            line-height: 15pt;
            cursor: pointer;
        }
        .icon img, .icon span {
            float: left;
        }
        .icon span {
            margin: 30px;
        }
        .icon small {
            font-size: 12pt;
            font-weight: normal;
        }
        .icon img {
            margin-top: 10px;
            width: 80px;
            height: 80px;
        }
        .row {
            display: grid;
            grid-auto-flow: column;
            grid-template-columns: min-content auto;
        }
        .col {
            overflow: hidden;
        }
        .col p {
            margin-top: 0;
            padding-left: 10px;
        }
        .col h2 {
            width: 250px;
            text-align: center;
        }
        #og-plonky img {
            max-width: 300px;
        }
        #og-plonky p {
            margin-top: 10px;
            padding-left: 0px;
        }
        #request-title {
            margin-left:0 !important;
        }
        
        @media (min-width: 760px) and (max-width: 1024px) {
            html {
                padding: 2px;
            }
            body {
                width: calc(100% - 4px);
            }
        }
        @media screen and (max-width: 760px) {
            #mobile {
                display: block !important;
                
            }
            #mobile .box {
                width: 95%;
                top: 120px !important;
            }
            #mobile .icon {
                padding: 5px;
                font-size: 18pt;
            }
            #mobile .icon span {
                margin: 20px 10px 10px 10px;
            }
            #mobile .icon img {
                margin-top: 0px;
                width: 80px;
                height: 80px;
            }
            #mobile .box-content {
                padding: 10px 20px;
            }
            #mobile .box-title {
                padding: 10px;
            }

            #projects, main, #quick-menu-button {
                display: none !important;
            }
        }
        </style>";
    }
}