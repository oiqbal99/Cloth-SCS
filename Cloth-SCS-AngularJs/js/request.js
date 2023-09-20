class HTTPRequest {
    /*
    This class provides a quick static interface to perform REST API operations
    having "function", "arguments", and "callback" parameters.
    */
    static async post(url, params) {
        return $.ajax({
            url: url,
            method: "POST",
            data: {
                fn: params["function"],
                args: params["arguments"] ?? []
            },
            dataType: "json",
            success: params["callback"]
        });
    }
}