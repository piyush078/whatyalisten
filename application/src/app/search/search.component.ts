import { Component, OnInit } from '@angular/core';

import { ApiService } from '../api.service';
import { ErrorService } from '../error.service';

@Component ({
  selector: 'search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})

export class SearchComponent implements OnInit {

  /**
   * Variable to store response.
   * Variables for parameters for search.
   *
   * @var mixed
   */
  private results: Object;
  private query: Object = {
    type: 'track',
    limit: 1
  };
  private url = 'search';

  /**
   * Constructor of SearchComponent.
   *
   * @param  class, class
   * @return void
   */
  constructor (
    private api: ApiService,
    private error: ErrorService
  ) {}
  ngOnInit () {}

  /**
   * Call the function for the search request.
   *
   * @param  void
   * @return void
   */
  search (): void {
    this.sendRequest ();
  }

  /**
   * Send the search request to service provider.
   *
   * @param  void
   * @return void
   */
  sendRequest (): void {
    this.api.fetchData (this.url, this.query).subscribe (
      data => this.results = data,
      error => this.error.formatError (error)
    );
  }
}
