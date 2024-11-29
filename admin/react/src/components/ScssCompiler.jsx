import * as React from "react";
import {v4 as uuidv4, v5 as uuidv5} from 'uuid';
import {Col, Row, Form, FloatingLabel, Collapse} from "react-bootstrap";

const v5NameSpace = '9557a282-6f29-407b-b21f-401acfdcb948';
const sleep = ms =>
    new Promise(resolve => setTimeout(resolve, ms));

export default class ScssCompiler extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {}

        this.findArrayElementById = this.findArrayElementById.bind(this);
        this.filterArrayElementById = this.filterArrayElementById.bind(this);
    }

    findArrayElementById(array, id, type) {
        return array.find((element) => {
            return element[type] === id;
        })
    }

    filterArrayElementById(array, id, type) {
        return array.filter((element) => {
            return element[type] !== id;
        })
    }

    render() {
        return (
            <React.Fragment>
                <div className="card card-body bg-light mb-2 shadow-sm">
                    <Form.Check
                        type="switch"
                        className="no-blur me-4"
                        id={uuidv4()}
                        checked={this.props.settings.scss_active || false}
                        onChange={(e) => this.props.onSetSettings(e.target.checked, 'scss_active')}
                        label={synCssClient.lang['SCSS compiler active']}
                    />
                    <hr/>
                    <h6>{synCssClient.lang['Set up paths']}</h6>
                    <hr className="mt-1 mb-3"/>
                    <fieldset disabled={!this.props.settings.scss_active}>
                        <Row className="g-2">
                            <Col xl={6} xs={12}>
                                <FloatingLabel
                                    controlId={uuidv4()}
                                    label={`${synCssClient.lang['scss_location']} *`}
                                >
                                    <Form.Control
                                        className={`no-blur`}
                                        required={true}
                                        type="text"
                                        value={this.props.settings.source || ''}
                                        onChange={(e) => this.props.onSetSettings(e.target.value, 'source')}
                                        placeholder={synCssClient.lang['scss_location']}/>
                                </FloatingLabel>
                                <button onClick={() => this.props.onOpenLocation('source')}
                                    type="button"
                                    className="btn-show-folder-tree btn btn-blue-outline btn-sm my-3">
                                    <i className="bi bi-folder2-open me-2"></i>
                                    {synCssClient.lang['Select location']}
                                </button>
                            </Col>
                            <Col xl={6} xs={12}>
                                <FloatingLabel
                                    controlId={uuidv4()}
                                    label={`${synCssClient.lang['css_location']} *`}
                                >
                                    <Form.Control
                                        className={`no-blur`}
                                        required={true}
                                        type="text"
                                        value={this.props.settings.destination || ''}
                                        onChange={(e) => this.props.onSetSettings(e.target.value, 'destination')}
                                        placeholder={synCssClient.lang['css_location']}/>
                                </FloatingLabel>
                                <button onClick={() => this.props.onOpenLocation('destination')}
                                        type="button"
                                        className="btn-show-folder-tree btn btn-blue-outline btn-sm my-3">
                                    <i className="bi bi-folder2-open me-2"></i>
                                    {synCssClient.lang['Select location']}
                                </button>
                            </Col>
                        </Row>
                        <hr/>
                        <h6>{synCssClient.lang['Cache Settings']}</h6>
                        <hr/>
                        <Form.Check
                            type="switch"
                            className="no-blur me-4"
                            id={uuidv4()}
                            checked={this.props.settings.cache_active || false}
                            onChange={(e) => this.props.onSetSettings(e.target.checked, 'cache_active')}
                            label={synCssClient.lang['Cache active']}
                        />
                        <Collapse in={this.props.settings.cache_active}>
                            <div id={uuidv5('cacheActive', v5NameSpace)}>
                                <div className="mt-3">
                                    <Col xs={12}>
                                        <FloatingLabel
                                            controlId={uuidv4()}
                                            label={`${synCssClient.lang['Cache path']}`}
                                        >
                                            <Form.Control
                                                className={`no-blur`}
                                                required={false}
                                                type="text"
                                                value={this.props.settings.cache_dir || ''}
                                                onChange={(e) => this.props.onSetSettings(e.target.value, 'cache_dir')}
                                                placeholder={synCssClient.lang['Cache path']}/>
                                        </FloatingLabel>
                                        <button onClick={() => this.props.onDeleteCache()}
                                                type="button"
                                                className="btn-show-folder-tree btn btn-blue-outline btn-sm my-3">
                                            {synCssClient.lang['Empty cache']}
                                        </button>
                                    </Col>
                                </div>

                            </div>
                        </Collapse>

                        <hr/>
                        <h6>{synCssClient.lang['Output settings']}</h6>
                        <hr/>
                        <Row className="gx-2">
                            <Col xl={6} xs={12}>
                                <FloatingLabel
                                    controlId={uuidv4()}
                                    label={synCssClient.lang['Output']}>
                                    <Form.Select
                                        className={`no-blur mw-100`}
                                        value={this.props.settings.formatter_mode || ''}
                                        onChange={(e) => this.props.onSetSettings(e.target.value, 'formatter_mode')}
                                        aria-label={synCssClient.lang['Output']}>
                                        {this.props.selects.select_formatter_mode.map((select, index) =>
                                            <option key={index} value={select.value}>
                                                {select.label}
                                            </option>
                                        )}
                                    </Form.Select>
                                </FloatingLabel>
                            </Col>
                            <Col xl={6} xs={12}>
                                <FloatingLabel
                                    controlId={uuidv4()}
                                    label={synCssClient.lang['Source Map Optionen']}>
                                    <Form.Select
                                        className={`no-blur mw-100`}
                                        disabled={!this.props.settings.map_active}
                                        value={this.props.settings.map_option || ''}
                                        onChange={(e) => this.props.onSetSettings(e.target.value, 'map_option')}
                                        aria-label={synCssClient.lang['Source Map Optionen']}>
                                        {this.props.selects.select_map_option.map((select, index) =>
                                            <option key={index} value={select.value}>
                                                {select.label}
                                            </option>
                                        )}
                                    </Form.Select>
                                </FloatingLabel>
                            </Col>
                        </Row>
                        <hr/>
                        <div className="d-flex flex-wrap">
                            <Form.Check
                                type="switch"
                                className="no-blur me-4"
                                id={uuidv4()}
                                checked={this.props.settings.map_active || false}
                                onChange={(e) => this.props.onSetSettings(e.target.checked, 'map_active')}
                                label={synCssClient.lang['Create source map']}
                            />
                            <Form.Check
                                type="switch"
                                className="no-blur me-4"
                                id={uuidv4()}
                                checked={this.props.settings.enqueue_aktiv || false}
                                onChange={(e) => this.props.onSetSettings(e.target.checked, 'enqueue_aktiv')}
                                label={`${synCssClient.lang['Create enqueue stylesheets']} *`}
                            />
                            <Form.Check
                                type="switch"
                                className="no-blur me-4"
                                id={uuidv4()}
                                checked={this.props.settings.scss_login_aktiv || false}
                                onChange={(e) => this.props.onSetSettings(e.target.checked, 'scss_login_aktiv')}
                                label={`${synCssClient.lang['Compiler only active at login']} *`}
                            />
                        </div>
                        <div className="form-text">
                            <p className="mb-0">
                                <span className="text-danger me-2">(1)</span>
                                {synCssClient.lang['stylesheets_are_automatically']}
                            </p>
                            <p>
                                <span className="text-danger me-2">(2)</span>
                                {synCssClient.lang['if_activated']}
                            </p>
                        </div>
                        <hr/>
                    </fieldset>
                </div>
            </React.Fragment>
        )
    }
}