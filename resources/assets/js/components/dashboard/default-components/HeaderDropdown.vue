<template>
      <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
          <img src="/storage/images/avatars/dev.png" class="img-avatar" alt="admin@bootstrapmaster.com">
        </template>
        <b-dropdown-header tag="div" class="text-center"><strong>Account</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-bell-o"></i> Updates<b-badge variant="info">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-envelope-o"></i> Messages<b-badge variant="success">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-tasks"></i> Tasks<b-badge variant="danger">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-item><i class="fa fa-comments"></i> Comments<b-badge variant="warning">{{itemsCount}}</b-badge></b-dropdown-item>
        <b-dropdown-header tag="div" class="text-center"><strong>Settings</strong></b-dropdown-header>
        <b-dropdown-item><i class="fa fa-user"></i> Profile</b-dropdown-item>
        <b-dropdown-item><i class="fa fa-lock"></i> Logout</b-dropdown-item>
      </b-nav-item-dropdown>
</template>
<script>
  export default {
    name: 'header-dropdown',
    data: () => {
      return { itemsCount: 42 }
    }
  }
</script>

