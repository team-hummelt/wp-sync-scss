import * as React from "react";
import {Card, CardBody} from "react-bootstrap";
import parser from 'react-html-parser';

export default class WelcomePage extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {}
    }

    render() {
        return (
            <React.Fragment>
                <div className="container">
                    <Card className="shadow-sm position-relative">
                        <CardBody style={{minHeight: '55vh'}} className="pb-4 px-4">
                            <div className="mb-4 mt-3 fs-2 fw-semibold">
                                {synCssClient.lang['Welcome to WP-SCSS-Sync!']}
                            </div>
                            <hr/>
                            <p style={{fontSize: '16px'}}>
                                {parser(synCssClient.lang['welcome_txt'])}
                            </p>
                            <hr/>
                            <div className="fs-5 fw-semibold">
                                {synCssClient.lang['First steps']}:
                            </div>
                            <ul className="ps-1 mt-3 list-unstyled">
                                <li className="d-flex mb-2">
                                    <b className="me-2 fw-semibold">1.</b>
                                    <span><b className="fw-semibold">{synCssClient.lang['first_steps_head1']}:</b> <br/>
                                        <span style={{lineHeight: 1.5}}>{synCssClient.lang['first_steps1']}</span>
                                    </span>
                                </li>
                                <li className="d-flex">
                                    <b className="me-2 fw-semibold">2.</b>
                                    <span><b className="fw-semibold">{synCssClient.lang['first_steps_head2']}:</b> <br/>
                                        <span style={{lineHeight: 1.5}} >{synCssClient.lang['first_steps2']}</span>
                                    </span>
                                </li>
                                <li className="d-flex">
                                    <b className="me-2 fw-semibold">3.</b>
                                    <span><b className="fw-semibold">{synCssClient.lang['first_steps_head3']}:</b> <br/>
                                        <span style={{lineHeight: 1.5}} >{synCssClient.lang['first_steps3']}</span>
                                    </span>
                                </li>
                            </ul>
                            <div className="fs-5 fw-semibold">
                                {synCssClient.lang['Useful functions']}:
                            </div>
                            <ul className="ps-1 mt-3" style={{listStyle: 'inside'}}>
                                <li>{parser(synCssClient.lang['useful_functions1'])}</li>
                                <li>{parser(synCssClient.lang['useful_functions2'])}</li>
                                <li>{parser(synCssClient.lang['useful_functions3'])}</li>
                            </ul>
                            <hr/>
                            <div className="mb-2 fs-5 fw-semibold text-blue">
                                {synCssClient.lang['spende_headline']}
                            </div>
                            <p style={{fontSize: '16px'}}>
                                {synCssClient.lang['spende_txt']}
                            </p>
                            <div className="fs-5 text-blue fw-semibold">
                                {synCssClient.lang['Why donate']}
                            </div>
                            <ul className="ps-1 mt-3" style={{listStyle: 'inside'}}>
                                <li>{parser(synCssClient.lang['why_donate1'])}</li>
                                <li>{parser(synCssClient.lang['why_donate2'])}</li>
                                <li>{parser(synCssClient.lang['why_donate3'])}</li>
                            </ul>
                            <div className="fs-5 mb-2 text-blue fw-semibold">
                                {synCssClient.lang['How can you help']}
                            </div>
                            <p style={{fontSize: '16px'}}>
                                {synCssClient.lang['how_can_help_txt1']}<br/>
                                {synCssClient.lang['how_can_help_txt2']}
                            </p>
                            <a target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=WRZJAC9L2GYNJ" className="btn btn-blue">
                                <i className="bi bi-paypal me-2"></i>
                                PayPal
                            </a>
                            <div className="fw-semibold mt-3">
                                {synCssClient.lang['Thank you very much for your support!']}
                            </div>
                            <p style={{fontSize: '16px'}}>
                                {synCssClient.lang['Together we make WP-SCSS-Sync even better.']}
                            </p>
                            <hr/>
                        </CardBody>
                    </Card>
                </div>
            </React.Fragment>
        )
    }
}