import React from "react";
import {Collapse} from "react-bootstrap";
import {v4 as uuidv4} from 'uuid';
import {useState} from "react";

const RecursiveComponent = ({data, callback, onSetTriggerResetFolder, reset}) => {
    const [showNested, setShowNested] = useState({});
    const [showNestedFile, setShowNestedFile] = useState({});
    // handle show/hide functionality
    const toggleNested = (e, parent) => {
        let folderHref = jQuery('.folder-href');
        let hasClass = jQuery(e.currentTarget).hasClass('active');
        folderHref.removeClass('active')
        if (!hasClass ) {
            jQuery(e.currentTarget).addClass('active')
        }
        setShowNested({...showNested, [parent.id]: !showNested[parent.id]});
        parent.status = !showNested[parent.id]
        callback(parent)
    };
    const toggleNestedFiles = (e, parent) => {
        let fileHref = jQuery('.file');
        let fileHasClass = jQuery(e.currentTarget).hasClass('active');
        fileHref.removeClass('active')
        if(!fileHasClass){
            jQuery(e.currentTarget).addClass('active')
        }
        setShowNestedFile({...showNestedFile, [parent.id]: !showNestedFile[parent.id]});
        parent.status = !showNestedFile[parent.id]
        callback(parent)
    }

    if(reset){
        console.log(showNested)
        setShowNestedFile({});
        onSetTriggerResetFolder(false)
    }

    return (
        <React.Fragment>
            {data.map((parent, i) => {
                return (
                    <ul className={`mb-0 ${parent.first ? 'first' : ''}`} key={parent.id}>
                        {parent.isFolder ?
                            <li className={`folder ${showNested[parent.id] && parent.children.length ? 'expanded' : 'collapsed first'}`}>
                                <span
                                    className={`cursor-pointer folder-href d-block`}
                                    onClick={(e) => toggleNested(e, parent)}>
                                    {parent.name}
                                </span>
                            </li>
                            : ''}
                        {!parent.isFolder ?
                            <li  onClick={(e) => toggleNestedFiles(e, parent)}
                                className={`${showNestedFile[parent.id] ? 'active' : ''} file ext_${parent.ext}`}>{parent.name}</li>
                            :
                            <Collapse in={showNested[parent.id]}>
                                <div className="three-collapse" id={uuidv4()}>
                                    {parent.children && <RecursiveComponent
                                        data={parent.children}
                                        callback={callback}
                                        onSetTriggerResetFolder={onSetTriggerResetFolder}
                                        reset={reset}
                                    />}
                                </div>
                            </Collapse>}
                    </ul>
                );
            })}
        </React.Fragment>
    );
};

export default RecursiveComponent;