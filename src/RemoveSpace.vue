<!--
	@copyright Copyright (c) 2017 Arawa

	@author 2023 Baptiste Fotia <baptiste.fotia@arawa.fr>
	@author 2023 Andrei Zheksi <andrei.zheksi@arawa.fr>

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
	<NcModal class="remove-modal"
		size="small"
		@close="close()">
		<div class="modal__content">
			<h2>
				{{ t('workspace', 'Are you sure you want to delete the {space} workspace ?', { space }) }}
			</h2>
			<div class="remove-space-actions">
				<NcButton
					type="secondary"
					@click="handleCancel()">
					{{ t('workspace', 'Cancel') }}
				</NcButton>
				<NcButton
					type="error"
					@click="handleDelete()">
					{{ t('workspace', 'Delete space') }}
				</NcButton>
			</div>
		</div>
	</NcModal>
</template>

<script>
import NcButton from '@nextcloud/vue/components/NcButton'
import NcModal from '@nextcloud/vue/components/NcModal'

export default {
	name: 'RemoveSpace',
	components: {
		NcButton,
		NcModal,
	},
	props: {
		spaceName: { type: String, default: '' },
	},
	data() {
		return {
			space: this.spaceName,
		}
	},
	methods: {
		handleCancel() {
			this.$emit('handle-cancel')
		},
		handleDelete() {
			this.$emit('handle-delete')
		},
		close() {
			this.$emit('close')
		},
	},
}
</script>
<style scoped>
.remove-modal :deep(.modal-wrapper .modal-container .modal__content) {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	width: 600px;
	height: 100%;
}

.remove-modal :deep(.modal-wrapper .modal-container) {
	height: 200px;
	min-width: 600px;
}

.remove-modal :deep(.modal-wrapper .modal-container .modal__content h2) {
	font-weight: bold;
	font-size: 16px;
	text-align: center;
}

.remove-modal {
	min-height: 8rem;
}
.remove-space-actions {
	margin-top: 1.5rem;
	display: flex;
}

.remove-space-actions button {
	margin: 0 1rem;
}

</style>
