<!--
	@copyright Copyright (c) 2017 Arawa

	@author 2024 Baptiste Fotia <baptiste.fotia@arawa.fr>

	@license GNU AGPL version 3 or any later version

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as
	published by the Free Software Foundation, either version 3 of the
	License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->

<template>
	<div class="user-card">
		<div class="avatar">
			<div class="icon-member" :class="$store.getters.isMember($route.params.space, user) ? 'is-member' : ''" />
			<NcAvatar :display-name="user.name" :user="user.uid" :show-user-status="false" />
			<div class="user-name">
				<span>{{ user.name }}</span>
			</div>
		</div>
		<div class="user-entry-actions">
			<div v-if="!$store.getters.isGEorUGroup($route.params.space, decodeURIComponent(decodeURIComponent($route.params.slug)))">
				<NcCheckboxRadioSwitch type="checkbox"
					class="role-toggle"
					:checked="isWorkspaceManager(user.role)"
					:disabled="$store.getters.isMember($route.params.space, user)"
					@update:checked="toggleUserRole(user)">
					{{ t('workspace', 'WM') }}
				</NcCheckboxRadioSwitch>
			</div>
			<NcActions>
				<NcActionButton icon="icon-delete"
					@click="removeUserFromBatch(user)">
					{{ t('workspace', 'remove users from selection') }}
				</NcActionButton>
			</NcActions>
		</div>
	</div>
</template>

<script>
import NcCheckboxRadioSwitch from '@nextcloud/vue/components/NcCheckboxRadioSwitch'
import NcActionButton from '@nextcloud/vue/components/NcActionButton'
import NcActions from '@nextcloud/vue/components/NcActions'
import NcAvatar from '@nextcloud/vue/components/NcAvatar'

export default {
	name: 'UserCard',
	components: {
		NcAvatar,
		NcActions,
		NcActionButton,
		NcCheckboxRadioSwitch,
	},
	props: {
		user: {
			type: Object,
			default: () => {},
		},
	},
	methods: {
		toggleUserRole(user) {
			this.$emit('toggle-role', user)
		},
		removeUserFromBatch(user) {
			this.$emit('remove-user', user)
		},
		isWorkspaceManager(role) {
			role = role.toLowerCase()
			return role === 'wm'
		},
	},
}
</script>

<style scoped>

.avatar {
  width: 75%;
}

.user-card {
	display: flex;
}

.user-name {
	margin-left: 10px;
	max-width: 440px;
}

.icon-member {
	position: relative;
	left: 10px;
	top: -10px;
	z-index: 10;
	width: 20px;
	height: 20px;
}

.is-member {
	background-image: url('../img/member.png');
	background-repeat: no-repeat;
	background-position: center center;
	background-size: contain;
}

.avatar {
	align-items: center;
	display: flex;
	flex-flow: row;
}

.user-entry-actions {
	display: flex;
}

</style>
