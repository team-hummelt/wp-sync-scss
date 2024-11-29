import * as React from "react";
import {v4 as uuidv4, v5 as uuidv5} from 'uuid';
import {Col, Row, Form, FloatingLabel} from "react-bootstrap";

export default class PluginSettings extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {}
    }
    render() {
        return (
            <React.Fragment>
                <Row>
                    {this.props.selects && this.props.selects.select_user_role.length ?
                        <Col xl={6} xs={12}>
                            <FloatingLabel
                                controlId={uuidv4()}
                                label={synCssClient.lang['Minimum requirement for using this plugin']}>
                                <Form.Select
                                    className={`no-blur mw-100`}
                                     value={this.props.settings.user_role || ''}
                                     onChange={(e) => this.props.onSetSettings(e.target.value, 'user_role')}
                                    aria-label={synCssClient.lang['Minimum requirement for using this plugin']}>
                                    {this.props.selects.select_user_role.map((select, index) =>
                                        <option key={index} value={select.value}>
                                            {select.name}
                                        </option>
                                    )}
                                </Form.Select>
                            </FloatingLabel>
                        </Col>
                        : ''}
                </Row>
            </React.Fragment>
        )
    }
}