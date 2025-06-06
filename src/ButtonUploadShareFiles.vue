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
	<div>
		<NcButton @click="shareCsvFromFiles()">
			<template #icon>
				<Folder :size="20" />
			</template>
			{{ t('workspace', 'Choose from Files') }}
		</NcButton>
	</div>
</template>

<script>
import { getFilePickerBuilder } from '@nextcloud/dialogs'
import NcButton from '@nextcloud/vue/components/NcButton'
import showNotificationError from './services/Notifications/NotificationError.js'
import Folder from 'vue-material-design-icons/Folder.vue'

const picker = getFilePickerBuilder(t('deck', 'File to share'))
	.setMultiSelect(false)
	.setType(1)
	.allowDirectories()
	.build()

export default {
	name: 'ButtonUploadShareFiles',
	components: {
		NcButton,
		Folder,
	},
	props: {
		allSelectedUsers: {
			type: Array,
			default: () => [],
		},
	},
	methods: {
		shareCsvFromFiles() {
			picker.pick()
				.then(async (path, title) => {
					const space = this.$store.getters.getSpaceByNameOrId(this.$route.params.space)
					const bodyFormData = new FormData()
					bodyFormData.append('path', path)
					try {
						const users = await this.$store.dispatch('importCsvFromFiles', { formData: bodyFormData, spaceId: space.id })
						let usersToDisplay = this.filterAlreadyPresentUsers(users)
						usersToDisplay = this.addSubtitleToUsers(usersToDisplay)
						// this.allSelectedUsers = [...this.allSelectedUsers, ...usersToDisplay]
						this.$emit('push', [...this.allSelectedUsers, ...usersToDisplay])
					} catch (err) {
						let duration = 10000

						// change the duration of the notification
						// related to the number of the word.
						if (err.response.data.data.message.split(' ').length >= 30) {
							duration = 13000
						}

						const title = err.response.data.data.title
						const text = err.response.data.data.message
						showNotificationError(title, text, duration)
						console.error(err.response.data.exception)
					}
				})
		},
		// When adding users to a space, show only those users who are not already member of the space
		filterAlreadyPresentUsers(recvUsers) {
			let users = []
			if (this.$route.params.slug === undefined) {
				const space = this.$store.getters.getSpaceByNameOrId(this.$route.params.space)
				users = recvUsers.filter(user => {
					return (!(user.uid in space.users))
				}, space)
			} else {
				users = recvUsers.filter(user => {
					return (!(user.groups.includes(decodeURIComponent(decodeURIComponent(this.$route.params.slug)))))
				})
			}
			// Filters user that are already selected
			return users.filter(newUser => {
				return this.allSelectedUsers.every(user => {
					return newUser.uid !== user.uid
				})
			})
		},
		addSubtitleToUsers(users) {
			return users.map(user => {
				return {
					...user,
					subtitle: user.subtitle ?? '',
				}
			})
		},
	},
}

</script>
