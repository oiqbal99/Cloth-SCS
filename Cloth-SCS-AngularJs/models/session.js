class UserSession {
  /*
  This class provides a quick static interface to perform session operations
  which affect the user.
  */
  static async get_prop_safely(prop, defaultValue) {
    if (sessionStorage.getItem("user_login_id") === null) {
      return defaultValue;
    }
    const sessionUserId = sessionStorage.getItem("user_login_id");
    const sql = `SELECT * FROM User WHERE id = ${sessionUserId}`;
    const resPropValue = await new Promise((resolve) => {
      $
      .when(Query.run(sql))
      .done(function (res) {
        resolve(res[0][prop] ?? defaultValue);
      })
      .fail(function (_, textStatus) {
        console.error(textStatus);
      });
    });
    return resPropValue;
  }
}
