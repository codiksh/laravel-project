<script>
    $('#role').val(@json($user->getRoleNames()->toArray())).trigger('change');
</script>
