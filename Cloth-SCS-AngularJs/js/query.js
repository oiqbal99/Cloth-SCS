class Query {
    /*
    This class provides a quick static interface to perform an SQL query.
    */
    static run(sql, callback) {
      return $.ajax({
        url: "./api/query.php",
        method: "POST",
        data: { sql: sql },
        dataType: "json",
        success: callback
      });
    }
  }