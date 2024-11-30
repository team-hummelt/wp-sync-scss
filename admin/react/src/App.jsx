import * as React from "react";
import PluginPage from "./PluginPage";
import WelcomePage from "./WelcomePage";

export default class App extends React.Component {
    constructor(props) {
        super(props);
        this.props = props;
        this.formUpdTimeOut = '';
        this.state = {

        }
        this.urlSearchParam = this.urlSearchParam.bind(this);
    }

    urlSearchParam(search) {
        const authResult = new URLSearchParams(window.location.search);
        return authResult.get(search)
    }
    render() {

        return (
            <React.Fragment>
                {this.urlSearchParam('page') === 'scss-auto-compiler-options' && <PluginPage/>}
                {this.urlSearchParam('page') === 'scss-auto-compiler-welcome' && <WelcomePage/>}
            </React.Fragment>
        )
    }
}
