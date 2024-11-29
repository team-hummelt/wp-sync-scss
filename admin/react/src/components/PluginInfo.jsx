import * as React from "react";
import parser from 'react-html-parser';

export default class PluginInfo extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {}
    }

    render() {
        return (
            <React.Fragment>
                <div className="card card-body bg-light mb-2 shadow-sm">
                    <hr/>
                    <h5>{synCssClient.lang['Plugin Info']}</h5>
                    <hr className="mt-1 mb-3"/>
                    <div className="fs-6 mb-1 fw-semibold">{synCssClient.lang['Plugin name']}:</div>
                    <p style={{fontSize: '16px'}}>WP-SCSS-Sync</p>
                    <div className="fs-6 mb-1 fw-semibold">{synCssClient.lang['Plugin description']}:</div>
                    <p style={{fontSize: '16px'}}>{synCssClient.lang['description_txt']}</p>
                    <div className="fs-6 mb-1 fw-semibold">{synCssClient.lang['Features']}:</div>
                    <ul className="ps-1" style={{listStyle: 'inside'}}>
                        <li>{parser(synCssClient.lang['features1'])}</li>
                        <li>{parser(synCssClient.lang['features2'])}</li>
                        <li>{parser(synCssClient.lang['features3'])}</li>
                        <li>{parser(synCssClient.lang['features4'])}</li>
                        <li>{parser(synCssClient.lang['features5'])}</li>
                    </ul>
                    <div className="fs-6 mb-1 fw-semibold">{synCssClient.lang['Advantages']}:</div>
                    <ul className="ps-1" style={{listStyle: 'inside'}}>
                        <li>{parser(synCssClient.lang['advantages1'])}</li>
                        <li>{parser(synCssClient.lang['advantages2'])}</li>
                        <li>{parser(synCssClient.lang['advantages3'])}</li>
                    </ul>
                    <hr/>
                    <div className="fs-6 fw-semibold">
                        {synCssClient.lang['end_txt']}
                    </div>

                    <hr/>
                    <div className="mb-2 mt-3 fs-5 fw-semibold text-blue">
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
                    <span>
                    <a target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=WRZJAC9L2GYNJ"
                       className="btn btn-blue">
                        <i className="bi bi-paypal me-2"></i>
                        PayPal
                    </a>
                    </span>
                    <div className="fw-semibold mt-3">
                        {synCssClient.lang['Thank you very much for your support!']}
                    </div>
                    <p style={{fontSize: '16px'}}>
                        {synCssClient.lang['Together we make WP-SCSS-Sync even better.']}
                    </p>
                    <hr/>
                </div>
            </React.Fragment>
        )
    }
}