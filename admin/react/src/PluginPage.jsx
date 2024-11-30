import * as React from "react";
import axios from "axios";
import setAjaxData from "./components/utils/SetAjaxData";
import * as appTools from "./components/utils/appTools";
import {v5 as uuidv5} from 'uuid';
import {Card, CardBody, Collapse} from "react-bootstrap";
import PluginInfo from "./components/PluginInfo";
import PluginSettings from "./components/PluginSettings";
import ScssCompiler from "./components/ScssCompiler";
import SetAjaxResponse from "./components/utils/SetAjaxResponse";
import RecursiveComponent from "./components/RecursiveComponent";

const v5NameSpace = '9557a282-6f29-407b-b21f-401acfdcb948';

export default class PluginPage extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {
            version: '',
            colStart: true,
            colSettings: false,
            colInfo: false,
            collapseStartseite: true,
            colLocation: false,
            file_three: [],
            selectedFolder: '',
            selectedPath: '',
            selectedLocation: '',
            triggerResetFolder: false,
            selects: {
                select_formatter_mode: [],
                select_map_option: [],
                select_user_role: []
            },
            settings: {},
            spinner: {
                showAjaxWait: false,
                ajaxMsg: '',
                ajaxStatus: ''
            },
        }

        this.sendAxiosFormdata = this.sendAxiosFormdata.bind(this);
        this.onToggleCollapse = this.onToggleCollapse.bind(this);
        this.onToggleStartseiteCollapse = this.onToggleStartseiteCollapse.bind(this);
        this.onSetSettings = this.onSetSettings.bind(this);
        this.onUpdateSettingHandle = this.onUpdateSettingHandle.bind(this);
        this.onSetFolderData = this.onSetFolderData.bind(this);
        this.onCallbackRecursive = this.onCallbackRecursive.bind(this);
        this.onOpenLocation = this.onOpenLocation.bind(this);
        this.onSetTriggerResetFolder = this.onSetTriggerResetFolder.bind(this);
        this.onSetLocation = this.onSetLocation.bind(this);
        this.onDeleteCache = this.onDeleteCache.bind(this);
    }

    componentDidMount() {
        let formData = {
            'method': 'get_settings',
            'is_file': false
        }
        this.sendAxiosFormdata(formData).then()
    }

    onSetFolderData(change) {
        this.setState({
            folderData: change
        })
    }

    onToggleStartseiteCollapse(target) {
        let startseite = false;
        let folder = false;
        switch (target) {
            case 'startseite':
                startseite = true;
                break;
            case 'folder':
                folder = true;
                break;
        }
        this.setState({
            collapseStartseite: startseite,
            colLocation: folder,
        })
    }

    onToggleCollapse(target, resetFolder = false) {
        let start = false;
        let settings = false;
        let info = false;
        let folder = false;
        switch (target) {
            case 'start':
                start = true;
                break;
            case 'settings':
                settings = true;
                break;
            case 'info':
                info = true;
                break;
            case 'location':
                folder = true;
                break;
        }

        if (resetFolder) {

            this.setState({
                selectedFolder: '',
                selectedLocation: '',
                selectedPath: '',

            })
            let formData = {
                'method': 'get_settings',
                'is_file': false
            }
            this.sendAxiosFormdata(formData).then()
        }

        this.setState({
            colStart: start,
            colSettings: settings,
            colInfo: info,
            colLocation: folder,
        })
    }

    onSetTriggerResetFolder(state) {
        this.setState({
            triggerResetFolder: state
        })
    }

    onSetSettings(e, type) {
        let settings = this.state.settings;
        settings[type] = e;
        this.setState({
            settings: settings,
            spinner: {
                showAjaxWait: true,
            }
        })
        this.onUpdateSettingHandle(settings)
    }

    onUpdateSettingHandle(settings) {
        let _this = this;
        clearTimeout(this.formUpdTimeOut);
        this.formUpdTimeOut = setTimeout(function () {
            let formData = {
                'method': 'update_wp_sync_scss_settings',
                'data': JSON.stringify(settings),
            }
            _this.sendAxiosFormdata(formData).then()
        }, 1000);
    }

    onCallbackRecursive(varType) {
        let settings = this.state.settings;
        settings.destination = varType.path
        let name;
        varType.status ? name = varType.name : name = '';
        this.setState({
            selectedFolder: varType.name,
            selectedPath: varType.path
        })
    }

    onOpenLocation(type) {
        this.setState({
            selectedLocation: type
        })
        this.onToggleCollapse('location')
    }

    onSetLocation() {
        let formData = {
            'method': 'set_location',
            'path': this.state.selectedPath,
            'location': this.state.selectedLocation,
            'is_file': false
        }
        this.sendAxiosFormdata(formData).then()
    }

    onDeleteCache() {
        let formData = {
            'method': 'delete_cache'
        }
        this.sendAxiosFormdata(formData).then()
    }


    async sendAxiosFormdata(formData, isFormular = false, url = synCssClient.ajax_url) {
        if (formData) {
            await axios.post(url, setAjaxData(formData, isFormular))
                .then(({data = {}} = {}) => {
                    switch (data.type) {
                        case 'get_settings':
                            if (data.status) {
                                this.setState({
                                    version: data.version,
                                    settings: data.settings,
                                    file_three: data.file_three,
                                    selects: {
                                        select_formatter_mode: data.selects.select_formatter_mode,
                                        select_map_option: data.selects.select_map_option,
                                        select_user_role: data.selects.select_user_role
                                    }
                                })
                            } else {
                                appTools.warning_message(data.msg)
                            }
                            break;
                        case 'update_wp_sync_scss_settings':
                            this.setState({
                                spinner: {
                                    showAjaxWait: false,
                                    ajaxMsg: data.msg,
                                    ajaxStatus: data.status
                                }
                            })
                            break;
                        case 'set_location':
                            this.setState({
                                spinner: {
                                    showAjaxWait: false,
                                    ajaxMsg: data.msg,
                                    ajaxStatus: data.status
                                }
                            })
                            if (data.status) {
                                this.setState({
                                    file_three: data.file_three,
                                    settings: data.settings,
                                    selectedFolder: '',
                                    selectedLocation: '',
                                    selectedPath: '',
                                })
                                this.onToggleCollapse('start');
                            }
                            break;
                        case 'delete_cache':
                            if (data.status) {
                                appTools.success_message(data.msg)
                            } else {
                                appTools.warning_message(data.msg)
                            }
                            break;
                    }
                }).catch(err => console.error(err));
        }
    }

    render() {
        return (
            <React.Fragment>
                <div className="container">
                    <Card className="shadow-sm position-relative">
                        <h5 className="card-header d-flex align-items-center text-white  bg-orange py-4">
                            <i style={{fontSize: '2rem'}} className="bi bi-wordpress d-block me-2"></i>
                            {synCssClient.lang['SCSS AutoCompiler']}</h5>
                        <CardBody style={{minHeight: '55vh'}} className="pb-4">
                            <div className="col-12 mx-auto">
                                <Card className="shadow-sm">
                                    <div className="card-header d-flex align-items-center">
                                        <div className="fs-5 py-3">
                                            <i className="bi bi-tools me-2"></i>
                                            {synCssClient.lang['Settings']}
                                        </div>
                                        <div className="ms-auto">
                                            <div
                                                className={`ajax-spinner text-muted ${this.state.spinner.showAjaxWait ? 'wait' : ''}`}>
                                            </div>
                                            <small>
                                                <SetAjaxResponse
                                                    status={this.state.spinner.ajaxStatus}
                                                    msg={this.state.spinner.ajaxMsg}
                                                />
                                            </small>
                                        </div>
                                    </div>
                                    <CardBody style={{minHeight: '45vh'}} className="bg-custom-gray">
                                        <div className="d-flex flex-wrap align-items-center">
                                            <button onClick={() => this.onToggleCollapse('start')}
                                                    className={`btn btn-blue-outline btn-sm me-1 my-1 ${this.state.colStart ? 'active' : ''}`}>
                                                <i className="bi bi-gear me-2"></i>
                                                {synCssClient.lang['SCSS Compiler']}
                                            </button>
                                            <button onClick={() => this.onToggleCollapse('settings', true)}
                                                    className={`btn btn-blue-outline btn-sm me-1 my-1 ${this.state.colSettings ? 'active' : ''}`}>
                                                <i className="bi bi-wordpress me-2"></i>
                                                {synCssClient.lang['Settings']}
                                            </button>
                                            <div className="ms-auto">
                                                <button onClick={() => this.onToggleCollapse('info')}
                                                        className={`btn btn-blue-outline btn-sm me-1 my-1 ${this.state.colInfo ? 'active' : ''}`}>
                                                    <i className="bi bi-lightbulb me-2"></i>
                                                    {synCssClient.lang['Plugin Info']}
                                                </button>
                                            </div>
                                        </div>
                                        <hr/>
                                        <Collapse in={this.state.colStart}>
                                            <div id={uuidv5('collapseStart', v5NameSpace)}>
                                                <ScssCompiler
                                                    settings={this.state.settings}
                                                    selects={this.state.selects}
                                                    file_three={this.state.file_three}
                                                    onSetSettings={this.onSetSettings}
                                                    onSetFolderData={this.onSetFolderData}
                                                    onToggleCollapse={this.onToggleCollapse}
                                                    onOpenLocation={this.onOpenLocation}
                                                    onDeleteCache={this.onDeleteCache}
                                                />
                                            </div>
                                        </Collapse>
                                        <Collapse in={this.state.colLocation}>
                                            <div id={uuidv5('colLocation', v5NameSpace)}>
                                                <div className="card card-body bg-light mb-2 shadow-sm">
                                                    <hr/>
                                                    <h6 className="mb-0">
                                                        <i className="bi bi-folder2-open text-blue me-2"></i>
                                                        {synCssClient.lang['Select folder']}
                                                    </h6>
                                                    <hr/>
                                                    <div className="filetree start">
                                                        {this.state.file_three && this.state.file_three.length ?
                                                            <RecursiveComponent
                                                                data={this.state.file_three}
                                                                callback={this.onCallbackRecursive}
                                                                onSetTriggerResetFolder={this.onSetTriggerResetFolder}
                                                                reset={this.state.triggerResetFolder}
                                                            />
                                                            : ''}
                                                        <hr/>
                                                        {synCssClient.lang['Folder name']}: <i
                                                        className="text-blue">{this.state.selectedFolder || ''}</i>
                                                        <div className="mt-2">
                                                            <button
                                                                onClick={this.onSetLocation}
                                                                disabled={!this.state.selectedFolder}
                                                                className="btn btn-blue-outline btn-sm me-2">
                                                                <i className="bi bi-folder-plus me-2"></i>
                                                                {synCssClient.lang['Select folder']}
                                                            </button>
                                                            <button
                                                                onClick={() => this.onToggleCollapse('start', true)}
                                                                className="btn btn-outline-secondary btn-sm">
                                                                <i className="bi bi-x-lg me-2"></i>
                                                                {synCssClient.lang['cancel']}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </Collapse>
                                        <Collapse in={this.state.colSettings}>
                                            <div id={uuidv5('colSettings', v5NameSpace)}>
                                                <PluginSettings
                                                    settings={this.state.settings}
                                                    selects={this.state.selects}
                                                    onSetSettings={this.onSetSettings}
                                                />
                                            </div>
                                        </Collapse>
                                        <Collapse in={this.state.colInfo}>
                                            <div id={uuidv5('colInfo', v5NameSpace)}>
                                                <PluginInfo/>
                                            </div>
                                        </Collapse>
                                    </CardBody>
                                </Card>
                            </div>
                        </CardBody>
                        <div className="bottom-0 end-0 position-absolute my-1 me-3 text-end">
                            <small className="small-xl">
                                {synCssClient.lang['Version']}: <span
                                className="text-danger">v{this.state.version}</span>
                            </small>
                        </div>
                    </Card>
                </div>
                <div id="snackbar-success"></div>
                <div id="snackbar-warning"></div>
            </React.Fragment>
        )
    }
}
