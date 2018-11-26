import React, { Component } from 'react';
import { connect } from 'react-redux';
import {bindActionCreators} from 'redux'
import { Link } from 'react-router-dom';
import {fetchMenu} from '../../../actions';

import api from '../../../api';

import './index.css';

const mapStateToProps = (state) => ({
	mainMenu: state.api.menus.main
});

const mapDispatchToProps = (dispatch) => ({
	loadMenu: (menu) => dispatch({ type: 'LOAD_MENU', payload: menu }),
	actions: bindActionCreators({fetchMenu}, dispatch)
});

class Header extends Component {

	constructor(props) {
		super(props);
		this.props.loadMenu(api.Menus.bySlug('main'));
		this.buildMenu = this.buildMenu.bind(this);
	}

    componentDidMount() {
        this.props.actions.fetchMenu('short');
    }

	buildMenu() {
		if (this.props.mainMenu) {
			return this.props.mainMenu.map((item, i) => {
				return (
					<Link key={item.ID} to={item.url}>{item.title}</Link>
				);
			})
		}

		return null;
	}

	render() {
		// console.log(this.props.mainMenu);
		return (
			<header className="header-main">
				<nav>
					{this.buildMenu()}
				</nav>
			</header>
		);
	}
}

export default connect(mapStateToProps, mapDispatchToProps)(Header);
